<?php

namespace App\Controller;

use App\Entity\Domaines;
use App\Entity\Inscription;
use App\Entity\Ministere;
use App\Entity\User;
use App\Form\InscriptionArType;
use App\Form\InscriptionType;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use App\Repository\DomainesRepository;
use App\Repository\MinistereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, 
    DomainesRepository $domainesRepository, EntityManagerInterface $entityManager,MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $error= false;
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $domaine = explode('@',$email)[1];
            
            
            $domaines = $domainesRepository->findAll();
            $listes = array();
            foreach($domaines as $dom){
                    array_push($listes,$dom->getNom());
            }
           
            if(in_array($domaine,$listes)){
                // encode the plain password
                $user->setPassword(
                $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $user->setCover('user.png');
                $entityManager->persist($user);
                $entityManager->flush();
                // do anything else you need here, like send an email


                
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            
            $hashedId = hash('sha256', $user->getId());
            // send confirmation email
            $email = (new Email())
            ->from('dla@gmail.com')
            ->to($user->getEmail())
            ->subject('Test de MailDev')
            ->html(
                $this->renderView(
                    'registration/confirmation_email.html.twig',
                    ['id' => $user->getId(),
                    'hashedId' => $hashedId,]
                )
            );

            $mailer->send($email);
            $locale = $request->getLocale();
            if($locale =='fr'){
                $this->addFlash('success', 'un mail a été envoyé merci de confirmer pour accéder au platform');}
                else{
                    $this->addFlash('success', 'تم إرسال بريد إلكتروني ، يرجى التأكيد للوصول إلى المنصة ');
                }
             return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        
           }else{
              $error = true;
           }
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'error' => $error,
        ]);
    }
    
   

    /**
     * @Route("/personal-info/{id}/{hashedId}", name="personal_info")
     */
    public function personalInfo(Request $request,DomainesRepository $domainesRepository,ManagerRegistry $doctrine, $id): Response
    {

        $choix = $request->request->get('data');
        $locale = $request->getLocale();
       if($choix){
        $arr = [];
        $dom = $domainesRepository->findBy(['ministere'=> $choix]);
        
        foreach($dom as $dat){
            if($locale =='fr'){
                 $arr[] = [
                    'id' => $dat->getId(),
                    'category' => $dat->getCategorie(),
                ];
            }else{
				 $arr[] = [
                    'id' => $dat->getId(),
                    'category' => $dat->getCategorieAr(),
                ];
                
            }
        }
        
        return new JsonResponse($arr);
       }
        
        //dump($organismes);die;
        $hashedId = hash('sha256', $id);
        $idh = $request->get('hashedId');
        if(hash_equals($hashedId, $idh)) {
           
            $entityManager = $doctrine->getManager();
            $user = $entityManager->getRepository(User::class)->find($id);
            $inscription = new Inscription;
            
           
            if($locale =='fr'){
                $form = $this->createForm(InscriptionType::class,$inscription);
            }else{
                    $form = $this->createForm(InscriptionArType::class,$inscription);
             }
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // Save the user's personal information
                $user->setName($inscription->getName());
                $user->setPhone($inscription->getPhone());
                $user->setAge($inscription->getAge());
                $user->setGenre($inscription->getGenre());
                $user->setGouvernat($inscription->getGouvernorat());
                $user->setMinistere($inscription->getMinistere());
                $user->setOrganisme($inscription->getOrganisme());
                $user->setPoste($inscription->getPoste());
                $user->setGrade($inscription->getGrade());
                $user->setNiveau($inscription->getNiveau());
				$user->setDateAdd(new \DateTime());
                $user->setIsVerified(1);
                $user->setIdentifiant($inscription->getIdentifiant());
                $entityManager->flush();
                // Redirect to a success page or the homepage
                return $this->redirectToRoute('app_login');
            }
         } else {
            return $this->redirectToRoute('app_login');
        } 
        
        return $this->render('inscription/index.html.twig', [
            'form' => $form->createView(),
            'user'=>$user,
            'hashedId' =>$hashedId,
        ]);
    }
}
