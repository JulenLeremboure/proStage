<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ProStageController extends AbstractController
{
    /**
     * @Route("/pro/stage", name="pro_stage")
     */
    public function index()
    {
        return $this->render('pro_stage/index.html.twig', [
            'controller_name' => 'ProStageController',
        ]);
    }
    
    /**
     * @Route("/entreprises", name="entreprises")
     */
	public function msgBienvenue(){
        return $this->render('pro_stage/entreprises.html.twig');
    }

    /**
     * @Route("/pro/stage/entreprises", name="entreprises")
     */
    public function msgAccueilEntreprises(){

    }

    /**
     * @Route("/pro/stage/formations", name="formations")
     */
    public function msgAccueilFormations(){

    }

    /**
     * @Route("/pro/stage/stages/{id}", name="stageWithID")
     */
    public function msgAccueilDescriptifStage(int $id){

    }

}
