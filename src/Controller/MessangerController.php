<?php

namespace App\Controller;

use App\Entity\Messanger;
use App\Entity\User;
use App\Form\MessangerType;
use DateTimeInterface;
use App\Repository\MessangerRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessangerController extends AbstractController
{
    /**
     * @Route("/messanger/{id}", name="app_messanger")
     */
    public function index(Request $request,MessangerRepository $messangerRepo,EntityManagerInterface $manager,UserRepository $userRepository): Response
    {
        $id = $request->attributes->get('id');
        $messanger = New Messanger();
        $form = $this->createForm(MessangerType::class, $messanger);
        $form->handleRequest($request);
        $user = $this->getUser();

        

        $chats = $messangerRepo->findComments($user,$id);
        $chatsrec = $messangerRepo->findCommentsrec($user);

        $contact = $userRepository->findBy(['id'=>$id]);

        if ($form->isSubmitted() && $form->isValid()) {
            $messanger->setSender($user);
            $messanger->setContacter($contact[0]);
            $messanger->setDateAdd(new \DateTime());
            $manager->persist($messanger);
            $manager->flush();
            
            return $this->redirectToRoute('app_messanger', ['id'=>$id], Response::HTTP_SEE_OTHER);
        }
        return $this->render('messanger/index.html.twig', [
            'form' => $form->createView(),
            'chats'=>$chats,
            'chatrec'=>$chatsrec,
            'to'=>$contact[0],

        ]);
    }
}
