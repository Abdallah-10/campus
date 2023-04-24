<?php

namespace App\Controller;

use App\Entity\Temoignage;
use App\Form\TemoignageType;
use App\Repository\TemoignageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin/temoignage")
 */
class TemoignageController extends AbstractController
{
    /**
     * @Route("/", name="app_temoignage_index", methods={"GET"})
     */
    public function index(TemoignageRepository $temoignageRepository): Response
    {
        return $this->render('temoignage/index.html.twig', [
            'temoignages' => $temoignageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_temoignage_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TemoignageRepository $temoignageRepository,SluggerInterface $slugger): Response
    {
        $temoignage = new Temoignage();
        $form = $this->createForm(TemoignageType::class, $temoignage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('cover')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $temoignage->setCover($newFilename);
            }
            $temoignageRepository->add($temoignage, true);

            return $this->redirectToRoute('app_temoignage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('temoignage/new.html.twig', [
            'temoignage' => $temoignage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_temoignage_show", methods={"GET"})
     */
    public function show(Temoignage $temoignage): Response
    {
        return $this->render('temoignage/show.html.twig', [
            'temoignage' => $temoignage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_temoignage_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Temoignage $temoignage, TemoignageRepository $temoignageRepository,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(TemoignageType::class, $temoignage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('cover')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $temoignage->setCover($newFilename);
               
            }else{
                $temoignage->setCover($temoignage->getCover());
            }
            $temoignageRepository->add($temoignage, true);

            return $this->redirectToRoute('app_temoignage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('temoignage/edit.html.twig', [
            'temoignage' => $temoignage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_temoignage_delete", methods={"POST"})
     */
    public function delete(Request $request, Temoignage $temoignage, TemoignageRepository $temoignageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$temoignage->getId(), $request->request->get('_token'))) {
            $temoignageRepository->remove($temoignage, true);
        }

        return $this->redirectToRoute('app_temoignage_index', [], Response::HTTP_SEE_OTHER);
    }
}
