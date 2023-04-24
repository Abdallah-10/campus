<?php

namespace App\Controller;

use App\Repository\FormationRepository;
use App\Repository\InscriptionRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(InscriptionRepository $inscriptionRepository, FormationRepository $formationRepository,EntityManagerInterface $em): Response
    {
        $inscripts = $inscriptionRepository->getNombreInscrit();
        $inscriptMal = $inscriptionRepository->getNombreInscritMal();
        $inscriptfemal = $inscriptionRepository->getNombreInscritfemal();
        $formats = $formationRepository->getNombreFormt();
        $nmbrTheme = $formationRepository->getNombreThem();
        $inscripts = $inscripts[0][1] ?? 0;
        $inscriptMal = $inscriptMal[0]["total"] ?? 0;
        $inscriptfemal = $inscriptfemal[0]["total"] ?? 0;
        $formats = $formats[0][1] ?? 0;
        $nmbrTheme = count($nmbrTheme) ?? 0;
        // chart js stat
        $inschart = [];
        $inscStatus = [];
        $inscriptions= $inscriptionRepository->findInscriptStatus();
        $inscriptionsAcc= $inscriptionRepository->findInscriptStatusAcc();
        $inscriptionsFonc= $inscriptionRepository->finInscFonction();
        
        $gouvern= $inscriptionRepository->finInscGouvern();

        $inscGenre =[] ;
        $inscSexh = [];
        $inscSexf = [];
        $inssexchart = [];
        

        foreach($gouvern as $inscpt){
            $inssexchart[] = $inscpt["gouvernorat"];
       
            $inscriptionsSexef= $inscriptionRepository->finInscSexeF($inscpt["gouvernorat"]);
            $inscriptionsSexeh= $inscriptionRepository->finInscSexeH($inscpt["gouvernorat"]);
            $inscSexh[] = $inscriptionsSexeh[0]["count"] ?? 0;
            $somme = $inscriptionsSexef[0]["count"] ?? 0;
            $inscSexf[] = $somme ;
        }
        $inspostchart=[];
        $inscposte=[];
        foreach($inscriptionsFonc as $inscpt){
            $inspostchart[] = $inscpt["poste"];
            $inscposte[] = $inscpt["count"];
        }
 
        foreach($inscriptions as $inscpt){
            $inschart[] = $inscpt["gouvernorat"];
            $inscStatus[] = $inscpt["count"];
        }

        
        $query = $em->createQuery('SELECT u.gouvernorat , COUNT(u.gouvernorat) AS total 
        FROM App\Entity\Inscription u  GROUP BY u.gouvernorat ORDER BY u.gouvernorat ASC ');
        $users = $query->getResult();
        //formtion KPI
        $formchart = [];
        $formthem = [];

        $formationsT = $formationRepository->finFormationType();
        foreach($formationsT as $formch){
            $formchart[] = $formch["thematique"];
            $formthem[] = $formch["count"];
        }
       
        return $this->render('admin/dashboard.html.twig', [
            'insgov' => json_encode($inschart),
            'inscount' => json_encode($inscStatus),
            'formtheme' => json_encode($formchart),
            'themcount' => json_encode($formthem),

            'inscposte' => json_encode($inscposte),
            'inspostchart' => json_encode($inspostchart),

            'inssexchart' => json_encode($inssexchart),
            'inscSexh' => json_encode($inscSexh),
            'inscSexf' => json_encode($inscSexf),

            'countInscrpt' => $inscripts,
            'countFormt' => $formats,
            'inscriptMal' => $inscriptMal,
            'inscriptfemal' => $inscriptfemal,
            'nmbrTheme' => $nmbrTheme,
        ]);
    }
	
}
