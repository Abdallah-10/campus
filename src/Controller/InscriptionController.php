<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\User;
use App\Form\InscriptionType;
use App\Repository\FormationRepository;
use App\Repository\InscriptionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Newslatter;
use App\Form\NewslatterType;
use App\Repository\NewslatterRepository;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class InscriptionController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_inscription")
     * @IsGranted("ROLE_USER")
     */
    public function index(FormationRepository $formationRepository,UserRepository $userRepository,
    ManagerRegistry $doctrine,InscriptionRepository $inscriptionRepository , Request $request,
	MailerInterface $mailer,NewslatterRepository $newslatterRepository): Response
    {
        
        $entityManager = $doctrine->getManager();
        $id = $request->query->get('id');
       
        $idUser = $this->getUser()->getId();
        $user = $entityManager->getRepository(User::class)->find($idUser);

        $formation = $formationRepository->find($id);
        if(!$formation){
            throw $this->createNotFoundException();
        }
        $inscription = new Inscription;
        $form = $this->createForm(InscriptionType::class,$inscription);
        $form->handleRequest($request);

        $newslatter = New Newslatter();
        $formf = $this->createForm(NewslatterType::class, $newslatter);
        $formf->handleRequest($request);

        if ($formf->isSubmitted() && $formf->isValid()) {

            $email = (new Email())
            ->from($newslatter->getEmail())
            ->to('you@example.com')
            ->subject('Test de MailDev')
            ->text('Ceci est un mail de test');
            $mailer->send($email);

            $newslatter->setDateAdd(new \DateTime());
            $newslatter->setStatus(true);
            $newslatterRepository->add($newslatter, true);
        }
        
        if ($form->isSubmitted() && $form->isValid()) {
           
			$user->setDateAdd(new \DateTime());
            $inscription->addFormation($formation);
            $inscription->setIdUser($user);
			$inscription->setAge($user->getAge());
		    $inscription->setEmail($user->getEmail());
            $inscriptionRepository->add($inscription, true);

            $entityManager->flush();
            $locale = $request->getLocale();
			if($locale =='fr'){
            $this->addFlash('success', 'Merci ! votre inscription a été bien envoyée');}
			else{
				$this->addFlash('success', 'شكرًا ! تم إرسال تسجيلك في التكوين بنجاح ');
			}
            return $this->redirectToRoute('app_list', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('inscription/index.html.twig', [
            'form' => $form->createView(),
			'formf' => $formf->createView(),
            'formation'=>$formation,
            'user'=>$user,
        ]);

    }

    /**
     * @Route("/admin/inscription", name="back_inscription")
     */

     public function backInscription(InscriptionRepository $inscriptionRepository){

        $inscription = $inscriptionRepository->findAll();
        
        return $this->render('inscription/back/index.html.twig', [

            'inscriptions'=>$inscription,
        ]);

    }

    /**
     * @Route("/admin/inscription/{id}", name="back_inscription_show", methods={"GET"})
     */
    public function show(Inscription $inscription): Response
    {
        $formation = $inscription->getFormation()->toArray();
        
        return $this->render('inscription/back/show.html.twig', [
            'inscription' => $inscription,
            'formation' => $formation[0],
        ]);
    }



}
