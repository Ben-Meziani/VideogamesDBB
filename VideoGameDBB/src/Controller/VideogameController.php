<?php

namespace App\Controller;

use App\Entity\Videogame;
use App\Form\Videogame1Type;
use App\Repository\VideogameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/videogame")
 */
class VideogameController extends AbstractController
{
    /**
     * @Route("/", name="videogame_index", methods={"GET"})
     */
    public function index(VideogameRepository $videogameRepository): Response
    {
        return $this->render('videogame/index.html.twig', [
            'videogames' => $videogameRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="videogame_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $videogame = new Videogame();
        $form = $this->createForm(Videogame1Type::class, $videogame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($videogame);
            $entityManager->flush();

            return $this->redirectToRoute('videogame_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('videogame/new.html.twig', [
            'videogame' => $videogame,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="videogame_show", methods={"GET"})
     */
    public function show(Videogame $videogame): Response
    {
        return $this->render('videogame/show.html.twig', [
            'videogame' => $videogame,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="videogame_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Videogame $videogame): Response
    {
        $form = $this->createForm(Videogame1Type::class, $videogame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('videogame_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('videogame/edit.html.twig', [
            'videogame' => $videogame,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="videogame_delete", methods={"POST"})
     */
    public function delete(Request $request, Videogame $videogame): Response
    {
        if ($this->isCsrfTokenValid('delete'.$videogame->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($videogame);
            $entityManager->flush();
        }

        return $this->redirectToRoute('videogame_index', [], Response::HTTP_SEE_OTHER);
    }
}
