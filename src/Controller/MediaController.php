<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Entity\Newslatter;
use App\Form\NewslatterType;
use App\Repository\ActualiteRepository;
use App\Repository\NewslatterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class MediaController extends AbstractController
{
    /**
     * @Route("/media", name="app_media")
     */
    public function index(Request $request, NewslatterRepository $newslatterRepository,
     MailerInterface $mailer,ActualiteRepository $actualiteRepository): Response
    {

        $newslatter = New Newslatter();
        $form = $this->createForm(NewslatterType::class, $newslatter);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

        
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
        return $this->render('media/index.html.twig', [
            'formf' => $form->createView(),
            'actualites' => $actualiteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/media/{slug}", name="app_actu_details", methods={"GET"})
     */
    public function showdetails( Actualite $actualite,Request $request,MailerInterface $mailer,NewslatterRepository $newslatterRepository): Response
    {
        $newslatter = New Newslatter();
        $form = $this->createForm(NewslatterType::class, $newslatter);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

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
        
        return $this->render('media/detail.html.twig', [
            'actualite' => $actualite,
            'formf' =>$form->createView(),
        ]);
    }
}
