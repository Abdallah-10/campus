<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Newslatter;
use App\Form\ContactType;
use App\Form\NewslatterType;
use App\Repository\ContactRepository;
use App\Repository\NewslatterRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class BesoinAideController extends AbstractController
{
    private $requestStack;
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/besoin/aide", name="app_besoin_aide")
     */
    public function index(NewslatterRepository $newslatterRepository,ContactRepository $contactrepo, Request $request, MailerInterface $mailer, PaginatorInterface $paginator): Response
    {
        $contact = new Contact();
        $formContact = $this->createForm(ContactType::class, $contact);
        //dump($request);die;
        $formContact->handleRequest($request);
        if ($formContact->isSubmitted() && $formContact->isValid()) {

            $contactrepo->add($contact, true);
            $request = $this->requestStack->getCurrentRequest();
            $locale = $request->getLocale();
            if($locale == 'ar'){
                $this->addFlash('success', ' شكرًا ! لقد تم ارسال رسالتك بنجاح');
            }else{
                $this->addFlash('success', 'Merci ! votre message a été bien envoyé');
            }
            $formContact->clear();
        }
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
        return $this->render('besoin_aide/index.html.twig', [
            'controller_name' => 'BesoinAideController',
            'formf' => $form->createView(),
            'formContact'=>$formContact->createView(),
        ]);
    }
}
