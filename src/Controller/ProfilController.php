<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\Like;
use App\Entity\Profil;
use App\Entity\User;
use App\Form\InscriptionType;
use App\Form\ProfilType;
use App\Form\UserType;
use App\Repository\FormationRepository;
use App\Repository\InscriptionRepository;
use App\Repository\LikeRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="app_profil")
     */
    public function index(Request $request,UserRepository $userRepository, LikeRepository $likeRepository,
    UserPasswordHasherInterface $passwordHasher,SluggerInterface $slugger, InscriptionRepository $inscriptionRepository,FormationRepository $formationRepository): Response
    {
        
        $user = $this->getUser();
        $id = $this->getUser()->getId();
    
        $formations =  $likeRepository->findBy(['user'=>$user]);


        $profil = new Profil();
        $form = $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);
        $contacts = $userRepository->findAll();

        $keyUp =  $request->request->get('data');
       
        if(isset($keyUp)){
           
            $data=[];
            $output = $userRepository->findContact($keyUp);
            foreach($output as $cont){
                array_push($data,["name"=>$cont->getName(),"id"=>$cont->getId(),"cover"=>$cont->getCover()]);
            }
            
            return new JsonResponse($data);
        }
        
        $inscripts = $inscriptionRepository->getMesFormations($id);
        $counts = $inscriptionRepository->getMesCounts($id);
        $countsAtt = $inscriptionRepository->getMesCountsAtt($id);
        $countsAcc = $inscriptionRepository->getMesCountsAcc($id);
       
        return $this->render('profil/index.html.twig', [
            'formations' =>$formations,
            'form' => $form->createView(),
            'user' => $user,
            'inscripts' =>$inscripts,
			'count' =>$counts[0][1],
			'countsAtt' =>$countsAtt[0][1],
			'countsAcc' =>$countsAcc[0][1],
            'contacts'=>$contacts,
        ]);
    }

    /**
     * @Route("/profil/upload", name="app_profil_upload")
     */
    public function uploadProfil(Request $request,SluggerInterface $slugger,UserRepository $userRepository)
    {
        $user = $this->getUser();
        $profil = new Profil();
        $form = $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);
        
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
    
            $user->setCover($newFilename);
            $userRepository->add($user, true);
          }
          return $this->json([
            'code' =>200,
            'message' =>"like bien ajouté",
           
         ],200);
        
    }
   
    /**
     * @Route("personal_info/{id}/edit", name="app_user_edit_front", methods={"GET", "POST"})
     */
    public function editInfo(Request $request,ManagerRegistry $doctrine,int $id, User $user): Response
    {
       

        //$inscription = new Inscription;
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
       
        $dateAdd = $user->getDateAdd();
		$naissance = $user->getAge();
        if ($form->isSubmitted() && $form->isValid()) {
			$user->setAge($naissance);
            $user->setDateAdd($dateAdd);
            $entityManager->flush();
            // Redirect to a success page or the homepage
            return $this->redirectToRoute('app_profil');
		
        }
         
        return $this->renderForm('profil/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
        
  }
}
