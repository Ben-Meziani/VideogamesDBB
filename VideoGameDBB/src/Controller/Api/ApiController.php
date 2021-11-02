<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Repository\VideogameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Videogame;
use App\Form\RegisterVideogameType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api", name="api_")
 */
class ApiController extends AbstractController
{

    /**
     * @Route("", name="list", methods={"GET"})
     */
    public function listVideoGame(ObjectNormalizer $objetNormalizer, VideogameRepository $videogameRepository)
    {
        $videogame = $videogameRepository->findAll();
        $serializer = new Serializer([$objetNormalizer]);
        $json = $serializer->normalize($videogame, null, ['groups' => 'api_videogame']);
        return $this->json($json);
    }

    /**
     * @Route("", name="create", methods={"POST"})
     */
    public function JsonCreateVideoGame(Request $request, EntityManagerInterface $em)
    {
        $data = json_decode($request->getContent(), true);
        if(isset($data)){
            $id = $data['categories'][0]['id'];
            $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
            if(is_null($id) || $id == 0 || $id > 5) {
                return new Response(
                    "Dude, l'id de la catégory n'est pas la bonne", 
                     Response::HTTP_OK
                );
            }
            $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
            $videogame = new Videogame();
            $videogame->setReleaseDate(new \DateTime($data['releaseDate']));
            $videogame->setImageFilename($data['imageFilename']);
            $videogame->addCategory($category);
            $form = $this->createForm(RegisterVideogameType::class, $videogame);
            $form->submit($data, true);
            if($form->isSubmitted()){
                $em->persist($videogame);
                $em->flush();
                //$this->addFlash('success', 'Bien créé avec succès');
                return $this->json($videogame, 201, [], ['groups' => 'api_videogame']);
            }
            
        }else{
            return new Response(
                "Dude, ta requète est mauvaise donc je te met une 400 !!!!!!!!!!!!!!!!!!!!", 
                 Response::HTTP_OK
            ); 
        }
    }

     /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);  
        $id = $data['categories'][0]['id'];
        $category = $em->getRepository(Category::class)->find($id);
        $videogame = new Videogame();
        $videogame->setReleaseDate(new \DateTime($data['releaseDate']));
        $videogame->setImageFilename($data['imageFilename']);
        $videogame->addCategory($category);
        $form = $this->createForm(RegisterVideogameType::class, $videogame);
        $form->submit($data, true);
        $em->flush();
        return $this->json($videogame, 201, [], ['groups' => 'api_videogame']);
    }


    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Videogame $videogame): Response
    {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($videogame);
            $entityManager->flush();
        return $this->redirectToRoute('videogame_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
