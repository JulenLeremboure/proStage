<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage")
     */
    public function afficherAccueil()
    {
        return $this->render('pro_stage/index.html.twig', [
            'controller_name' => 'ProStageController',
        ]);
    }

    /**
     * @Route("/entreprises", name="entreprises")
     */
    public function afficherEntreprises(){
        return $this->render('pro_stage/entreprises.html.twig');
    }

    /**
     * @Route("/formations", name="formations")
     */
    public function afficherFormations(){
        return $this->render('pro_stage/formations.html.twig');
    }

    /**
     * @Route("/stages/{id}", name="stage")
     */
    public function afficherStage(int $id){
        return $this->render('pro_stage/stage.html.twig',['id'=>$id,]);
    }

}
