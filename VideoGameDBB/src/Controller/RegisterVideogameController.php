<?php

namespace App\Controller;

use App\Entity\Videogame;
use App\Form\RegisterVideogameType;
use App\Repository\VideogameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


class RegisterVideogameController extends AbstractController
{
      /**
     * @var VideogameRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface 
     */
    private $em;

   public function __construct(VideogameRepository $repository, EntityManagerInterface $em)
   {
        $this->repository = $repository;
        $this->em = $em;
   }

    /**
     * @Route("/register/videogame", name="register_videogame")
     */
    public function index(): Response
    {
        return $this->render('register_videogame/index.html.twig', [
            'controller_name' => 'RegisterVideogameController',
        ]);
    }

    /**
     * @Route("/register/videogame/create", name="register_videogame_create")
     */
    public function new(Request $request)
    {
        $videogame = new Videogame;
        $form = $this->createForm(RegisterVideogameType::class, $videogame);
        $form->handleRequest($request);
        //$videogame->setCreatedAt(new DateTime());
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($videogame);
            $this->em->flush();
            //$this->addFlash('success', 'Bien créé avec succès');
            return $this->redirectToRoute('register_videogame');
        }
        return $this->render('register_videogame/new.html.twig', [
        
            "videogame" => $videogame, 
            "form" => $form->createView(),
            "controller_name" => "RegisterVideogameController",
        ]);
    }
}
