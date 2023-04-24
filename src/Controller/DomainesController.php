<?php

namespace App\Controller;

use App\Entity\Domaines;
use App\Form\DomainesType;
use App\Repository\DomainesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/domaines")
 */
class DomainesController extends AbstractController
{
    /**
     * @Route("/", name="app_domaines_index", methods={"GET"})
     */
    public function index(DomainesRepository $domainesRepository): Response
    {
        return $this->render('domaines/index.html.twig', [
            'domaines' => $domainesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_domaines_new", methods={"GET", "POST"})
     */
    public function new(Request $request, DomainesRepository $domainesRepository): Response
    {
        $domaine = new Domaines();
        $form = $this->createForm(DomainesType::class, $domaine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $domainesRepository->add($domaine, true);

            return $this->redirectToRoute('app_domaines_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('domaines/new.html.twig', [
            'domaine' => $domaine,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_domaines_show", methods={"GET"})
     */
    public function show(Domaines $domaine): Response
    {
        return $this->render('domaines/show.html.twig', [
            'domaine' => $domaine,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_domaines_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Domaines $domaine, DomainesRepository $domainesRepository): Response
    {
        $form = $this->createForm(DomainesType::class, $domaine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $domainesRepository->add($domaine, true);

            return $this->redirectToRoute('app_domaines_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('domaines/edit.html.twig', [
            'domaine' => $domaine,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_domaines_delete", methods={"POST"})
     */
    public function delete(Request $request, Domaines $domaine, DomainesRepository $domainesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$domaine->getId(), $request->request->get('_token'))) {
            $domainesRepository->remove($domaine, true);
        }

        return $this->redirectToRoute('app_domaines_index', [], Response::HTTP_SEE_OTHER);
    }
}
