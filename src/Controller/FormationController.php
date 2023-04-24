<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping\Id;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;



/**
 * @Route("/admin/formation")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/", name="app_formation_index", methods={"GET"})
     */
    public function index(FormationRepository $formationRepository,PaginatorInterface $paginator,Request $request): Response
    {
        $formations = $formationRepository->findAll();
        $formationsList = $paginator->paginate(
            $formations, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1)/*page number*/,
            8 /*limit per page*/
        );
        
        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
        ]);
    }

    /**
     * @Route("/new", name="app_formation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FormationRepository $formationRepository ,SluggerInterface $slugger): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
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

                $formation->setCover($newFilename);
               
            }
         
            $slug = $slugger->slug($formation->getTitle());
            $formation->setSlug($slug);
            $formationRepository->add($formation, true);

            return $this->redirectToRoute('app_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formation/new.html.twig', [
            'formation' => $formation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_formation_show", methods={"GET"})
     */
    public function show(Formation $formation): Response
    {
        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_formation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Formation $formation, FormationRepository $formationRepository,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(FormationType::class, $formation);
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

                $formation->setCover($newFilename);
               
            }else{
                $formation->setCover($formation->getCover());
            }
            $slug = $slugger->slug($formation->getTitle().'-'. $formation->getId());
            $formation->setSlug($slug);

            $formationRepository->add($formation, true);

            return $this->redirectToRoute('app_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formation/edit.html.twig', [
            'formation' => $formation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_formation_delete", methods={"POST"})
     */
    public function delete(Request $request, Formation $formation, FormationRepository $formationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
            $formationRepository->remove($formation, true);
        }

        return $this->redirectToRoute('app_formation_index', [], Response::HTTP_SEE_OTHER);
    }
}
