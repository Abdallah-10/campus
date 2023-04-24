<?php

namespace App\Controller;

use App\Entity\Ministere;
use App\Form\MinistereType;
use App\Repository\MinistereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/ministere")
 */
class MinistereController extends AbstractController
{
    /**
     * @Route("/", name="app_ministere_index", methods={"GET"})
     */
    public function index(MinistereRepository $ministereRepository): Response
    {
        return $this->render('ministere/index.html.twig', [
            'ministeres' => $ministereRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_ministere_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MinistereRepository $ministereRepository): Response
    {
        $ministere = new Ministere();
        $form = $this->createForm(MinistereType::class, $ministere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ministereRepository->add($ministere, true);

            return $this->redirectToRoute('app_ministere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ministere/new.html.twig', [
            'ministere' => $ministere,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ministere_show", methods={"GET"})
     */
    public function show(Ministere $ministere): Response
    {
        return $this->render('ministere/show.html.twig', [
            'ministere' => $ministere,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ministere_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Ministere $ministere, MinistereRepository $ministereRepository): Response
    {
        $form = $this->createForm(MinistereType::class, $ministere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ministereRepository->add($ministere, true);

            return $this->redirectToRoute('app_ministere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ministere/edit.html.twig', [
            'ministere' => $ministere,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ministere_delete", methods={"POST"})
     */
    public function delete(Request $request, Ministere $ministere, MinistereRepository $ministereRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ministere->getId(), $request->request->get('_token'))) {
            $ministereRepository->remove($ministere, true);
        }

        return $this->redirectToRoute('app_ministere_index', [], Response::HTTP_SEE_OTHER);
    }
}
