<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function afficherAccueil()
    {
        $listeStages = $this->getDoctrine()->getRepository(Stage::class)
                                            ->findAll();

        return $this->render('pro_stage/index.html.twig', [
            'listeStages' => $listeStages
        ]);
    }

    /**
     * @Route("/entreprises", name="entreprises")
     */
    public function afficherEntreprises(){
        $listeEntreprises = $this->getDoctrine()->getRepository(Entreprise::class)
        ->findAll();

        return $this->render('pro_stage/entreprises.html.twig', [
            'listeEntreprises' => $listeEntreprises
        ]);
    }

    /**
     * @Route("/stagesEntreprise/{id}", name="stagesEntreprise")
     */
    public function afficherStageEntreprise(int $id){

        $listeStagesEntreprise = $this->getDoctrine()->getRepository(Stage::class)
        ->findByEntreprise($id);


        $entreprise = $this->getDoctrine()->getRepository(Entreprise::class)
        ->find($id);


        return $this->render('pro_stage/stagesEntreprise.html.twig',
                    ['listeStagesEntreprise'=>$listeStagesEntreprise,
                    'entreprise' => $entreprise]);
    }


    /**
     * @Route("/formations", name="formations")
     */
    public function afficherFormations(){

        $listeFormations = $this->getDoctrine()->getRepository(Formation::class)
        ->findAll();

        return $this->render('pro_stage/formations.html.twig',
                    ['listeFormations'=>$listeFormations]);
    }

    /**
     * @Route("/stage/{id}", name="stage")
     */
    public function afficherStage(int $id){
        $stage = $this->getDoctrine()->getRepository(Stage::class)
        ->find($id);

        return $this->render('pro_stage/stage.html.twig',['stage'=>$stage]);
    }

}
