<?php

namespace App\Controller\Api;

use App\Repository\VideogameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
        dd($json[0]['releaseDate']);
        return $this->json($json);
    }
}