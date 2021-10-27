<?php

namespace App\Controller\Api;

use App\Repository\VideogameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Videogame;

/**
* @Route("/api", name="api_")
*/
class ApiController extends AbstractController
{

    /**
    * @Route("", name="list", methods={"GET"})
    */
    public function listVideoGame(ObjectNormalizer $objetNormalizer, VideogameRepository $videogameRepository){
        $videogame = $videogameRepository->findAll();
        $serializer = new Serializer([$objetNormalizer]);
        $json = $serializer->normalize($videogame, null, ['groups' => 'api_videogame']);
        return $this->json($json);
    }

    /**
    * @Route("", name="create", methods={"POST"})
    */
    public function JsonCreateVideoGame(SerializerInterface $serializer,VideogameRepository $videogameRepository, Request $request, EntityManagerInterface $em){
        $jsonRecu = $request->getContent();
        $videogame = $serializer->deserialize($jsonRecu, Videogame::class, 'json');
        $em->persist($videogame);
        $em->flush();
        dd($videogame);

        return $this->json($videogame, 201, [], ['groups' => 'api_videogame']);

    }
}