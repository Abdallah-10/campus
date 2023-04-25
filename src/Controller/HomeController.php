<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Data\SearchAdvance;
use App\Data\SearchData;
use App\Entity\Formation;
use App\Entity\Like;
use App\Entity\Newslatter;
use App\Entity\Rating;
use App\Form\NewslatterType;
use App\Form\RatingType;
use App\Form\SearchAvanceType;
use App\Form\SearchForm;
use App\Repository\ActualiteRepository;
use App\Repository\FormationRepository;
use App\Repository\LikeRepository;
use App\Repository\NewslatterRepository;
use App\Repository\PartenaireRepository;
use App\Repository\RatingRepository;
use App\Repository\TemoignageRepository;
use DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\SliderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(FormationRepository $formationRepository,NewslatterRepository $newslatterRepository,
     TemoignageRepository $temoignageRepository,Request $request, PartenaireRepository $partenaireRepository ,ActualiteRepository $actualiteRepository,
     MailerInterface $mailer, PaginatorInterface $paginator,SliderRepository $sliderRepository,TranslatorInterface $translator ): Response
    {
       
        $data = new SearchData();
        $forms = $this->createForm(SearchForm::class,$data);
        $forms->handleRequest($request);
        $formations = $formationRepository->findSearchh($data);
        
        $formationsList = $paginator->paginate(
            $formations, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1)/*page number*/,
            3 /*limit per page*/
        );

    
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
        return $this->render('home/index.html.twig', [
            'formf' => $form->createView(),
            'forms' =>$forms->createView(),
            'formations' => $formationsList,
            'temoignages' => $temoignageRepository->findAll(),
            'partenaires' => $partenaireRepository->findAll(),
			'sliders' => $sliderRepository->findAll(),
            'actualites' => $actualiteRepository->findAll(),
            
        ]);
    }
    
    /**
     * @Route("/list-formations", name="app_list")
     */
    public function show(NewslatterRepository $newslatterRepository,FormationRepository $formationRepository,
    ActualiteRepository $actualiteRepository,PaginatorInterface $paginator,Request $request,MailerInterface $mailer): Response
    {
        
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
        $data = new SearchData();
        $form = $this->createForm(SearchForm::class,$data);
        $form->handleRequest($request);
        
        $formations = $formationRepository->findSearch($data);
        
        $formationsList = $paginator->paginate(
            $formations, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1)/*page number*/,
            6 /*limit per page*/
        );
        return $this->render('home/formation.html.twig', [
            'formations' => $formationsList,
            'forms' =>$form->createView(),
            'formf' =>$formf->createView(),
			'actualites' => $actualiteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/formations", name="app_list-advance")
     */
    public function showAdvance(NewslatterRepository $newslatterRepository,FormationRepository $formationRepository, PaginatorInterface $paginator,Request $request,MailerInterface $mailer): Response
    {
        
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

        $data = new SearchAdvance();
        $form = $this->createForm(SearchAvanceType::class,$data);
        $form->handleRequest($request);
        
        $formations = $formationRepository->findSearchAdvance($data);
        
        $formationsList = $paginator->paginate(
            $formations, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1)/*page number*/,
            6 /*limit per page*/
        );
        return $this->render('home/advance.html.twig', [
            'formations' => $formationsList,
            'forms' =>$form->createView(),
            'formf' =>$formf->createView(),
        ]);
    }
    /**
     * @Route("/a-propos", name="app_propos", methods={"GET"})
     */
    
    public function showpropos(NewslatterRepository $newslatterRepository,Request $request,MailerInterface $mailer): Response
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
        return $this->render('home/a-propos.html.twig', [
            'formf' =>$form->createView(),
        ]);
    }

    /**
     * @Route("/list-formations/{slug}", name="app_formation_details", methods={"GET"})
     */
    public function showdetails(FormationRepository $formationRepository, Formation $formation,Request $request,MailerInterface $mailer,NewslatterRepository $newslatterRepository): Response
    {
        $newslatter = New Newslatter();
        $form = $this->createForm(NewslatterType::class, $newslatter);
        $form->handleRequest($request);

        $formations =  $formationRepository->findBy(['thematique'=>$formation->getThematique()]);
       
        foreach($formations as $key=>$value){
            if($value->getId() == $formation->getId()){
                unset($formations[$key]);
            }
        }

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
        
        return $this->render('home/formation-detail.html.twig', [
            'formation' => $formation,
             'formations' =>$formations,
            'formf' =>$form->createView(),
        ]);
    }
    /**
     * @Route("/partenaires", name="app_partenaire", methods={"GET"})
     */
    public function partenaire(PartenaireRepository $partenaireRepository,Request $request,
    MailerInterface $mailer,NewslatterRepository $newslatterRepository): Response
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
  
        return $this->render('home/partenaires.html.twig', [
            'partenaires' => $partenaireRepository->findAll(),
            'formf' =>$form->createView(),
        ]);
    }
    /**
     * @Route("/formation/like/{id}", name="app_like")
     */
    public function like(Formation $formation, EntityManagerInterface $manager,LikeRepository $likeRepository) : Response
    {
        $user = $this->getUser();
        if(!$user) return $this->json([
            'code' =>403,
            'message' =>"non autorisé"
        ],403);

        if($formation->isLikedByUser($user)){
            $like = $likeRepository->findOneBy(['post' => $formation,'user'=>$user]);
            
            $manager->remove($like);
            $manager->flush();
            return $this->json([
                'code' =>200,
                'message' =>"like supprimé",
                
                ],200);
        }
        $like = new Like();
        $like->setPost($formation);
        $like->setUser($user);
        $manager->persist($like);
        $manager->flush();
        return $this->json([
            'code' =>200,
            'message' =>"like bien ajouté",
           
         ],200);

    }


    /**
     * @Route("/formation/rating/{id}", name="app_profil_rating")
     */
    public function Rating(Request $request,Formation $formation, EntityManagerInterface $manager,RatingRepository $likeRepository) : Response
    {
       
        $score =  $request->request->get('rating');
        
        $user = $this->getUser();
        if(!$user) return $this->json([
            'code' => 403,
            'message' =>"non autorisé"
        ],403);

        if($formation->isRatingdByUser($user)){
            $rating = $likeRepository->findOneBy(['article' => $formation,'user'=>$user]);
            $rating->setScore($score);
            $manager->persist($rating);
            $manager->flush();
            return $this->json([
                'code' =>200,
                'message' =>"rating supprimé",
                
                ],200);
        }
        $rating = new Rating();
        $rating->setArticle($formation);
        $rating->setUser($user);
        $rating->setScore($score);
        $manager->persist($rating);
        $manager->flush();

        return $this->json([
            'code' =>200,
            'message' =>"rating bien ajouté",
           
         ],200);

    }
}
