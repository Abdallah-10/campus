<?php

namespace App\Controller;

use App\Entity\Newslatter;
use App\Form\NewslatterType;
use App\Repository\FaqRepository;
use App\Repository\NewslatterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class FaqController extends AbstractController
{
    /**
     * @Route("/faq", name="app_faq")
     */
    public function index(Request $request,NewslatterRepository $newslatterRepository,FaqRepository $faqRepository, MailerInterface $mailer): Response
    {

        
        $newslatter = New Newslatter();
        $form = $this->createForm(NewslatterType::class, $newslatter);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $email = (new Email())
            ->to('you@example.com')
            ->subject('Test de MailDev')
            ->text('Ceci est un mail de test');
            $mailer->send($email);


            $newslatter->setDateAdd(new \DateTime());
            $newslatter->setStatus(true);
            $newslatterRepository->add($newslatter, true);
        }
        return $this->render('faq/index.html.twig', [
            'faqs' => $faqRepository->findAll(),
            'formf' => $form->createView(),
        ]);
    }
}
