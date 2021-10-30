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
        $id = $data['categories'][0]['id'];
        if(isset($data) && isset($id)){
            // if(is_null($id) || 1 < $id && $id < 5) {
            //     return new Response(
            //         "Dude, l'id de la catégory n'est pas la bonne", 
            //          Response::HTTP_OK
            //     );
            // }
            $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
            $videogame = new Videogame();
            $videogame->setReleaseDate(new \DateTime($data['releaseDate']));
            $videogame->setImageFilename($data['imageFilename']);
            $videogame->addCategory($category);
            $form = $this->createForm(RegisterVideogameType::class, $videogame);
            $form->submit($data);
            $em->persist($videogame);
            $em->flush();
            
            return $this->json($videogame, 201, [], ['groups' => 'api_videogame']);
        }
    }
}
