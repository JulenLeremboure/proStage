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
     * @Route("/stagesEntreprise/{nom}", name="stagesEntreprise")
     */
    public function afficherStagesEntreprise(string $nom){

        //$listeStagesEntreprise = $this->getDoctrine()->getRepository(Stage::class)
        //->findByEntreprise($nom);

        $listeStagesEntreprise = $this->getDoctrine()->getRepository(Stage::class)
        ->fetchByNomEntreprise($nom);

        $entreprise = $this->getDoctrine()->getRepository(Entreprise::class)
        ->findOneByNom($nom);

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
     * @Route("/stagesFormation/{id}", name="stagesFormation")
     */
    public function afficherStagesFormation(int $id){

        $listeStagesFormation = $this->getDoctrine()->getRepository(Stage::class)
        ->fetchByFormation($id);


        $formation = $this->getDoctrine()->getRepository(Formation::class)
        ->findOneById($id);


        return $this->render('pro_stage/stagesFormation.html.twig',
                    ['listeStagesFormation'=>$listeStagesFormation,
                    'formation' => $formation]);
    }

    /**
     * @Route("/stage/{id}", name="stage")
     */
    public function afficherStage(int $id){
        $stage = $this->getDoctrine()->getRepository(Stage::class)
        ->find($id);

        return $this->render('pro_stage/stage.html.twig',['stage'=>$stage]);
    }

    /**
     * @Route("/ajoutEntreprise", name="ajoutEntreprise")
     */
    public function afficherFormulaire_AjoutEntreprise(){

        return $this->render('pro_stage/ajoutEntreprise.html.twig');
    }

}
