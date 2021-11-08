<?php

namespace App\Controller;

use App\Repository\VideogameRepository;
use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(VideogameRepository $videogameRepository, ApiService $api): Response
    {
        $token = $api->getToken();
        dd($token['access_token']);
        return $this->render('home/index.html.twig', [
            'videogames' => $videogameRepository->findLatest(),
        ]);
    }
}
