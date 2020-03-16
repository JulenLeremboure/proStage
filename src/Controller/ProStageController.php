<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;

use App\Form\EntrepriseType;
use App\Form\StageType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistance\ObjectManager;


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
    public function afficherFormulaire_AjoutEntreprise(Request $requeteHttp){

        $manager=$this->getDoctrine()->getManager();

        $entreprise = new Entreprise();

        $formulaireAjoutEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

        $formulaireAjoutEntreprise->handleRequest($requeteHttp);

        if($formulaireAjoutEntreprise->isSubmitted() && $formulaireAjoutEntreprise->isValid()){
            $manager->persist($entreprise);
            $manager->flush();

            return $this->redirectToRoute('entreprises');
        }

        return $this->render('pro_stage/ajoutEntreprise.html.twig',
                            ['vueFormulaireAjoutEntreprise' => $formulaireAjoutEntreprise -> createView()]);
    }

    /**
     * @Route("/modificationEntreprise/{id}", name="modificationEntreprise")
     */
    public function afficherFormulaire_ModificationEntreprise(Entreprise $entreprise, Request $requeteHttp){

        $manager=$this->getDoctrine()->getManager();

        $formulaireModificationEntreprise = $this->createForm(EntrepriseType::class, $entreprise);
        
        $formulaireModificationEntreprise->handleRequest($requeteHttp);

        if($formulaireModificationEntreprise->isSubmitted() && $formulaireModificationEntreprise->isValid()){

            $manager->persist($entreprise);
            $manager->flush();

            return $this->redirectToRoute('entreprises');
        }

        return $this->render('pro_stage/modificationEntreprise.html.twig',
                            ['vueFormulaireModificationEntreprise' => $formulaireModificationEntreprise -> createView()]);
    }

    /**
     * @Route("/ajoutStage", name="ajoutStage")
     */
    public function afficherFormulaire_ajoutStage(Request $requeteHttp){

        $manager=$this->getDoctrine()->getManager();

        $stage = new Stage();

        $formulaireAjoutStage = $this->createForm(StageType::class, $stage);
        
        $formulaireAjoutStage->handleRequest($requeteHttp);

        if($formulaireAjoutStage->isSubmitted() && $formulaireAjoutStage->isValid()){
            
            if($formulaireAjoutStage->getData()->getNouvelleEntreprise() != null){
                $donneesEntreprise = $formulaireAjoutStage->getData()->getNouvelleEntreprise();
                $nouvelleEntreprise = new Entreprise();
               
                $nouvelleEntreprise->setNom($donneesEntreprise->getNom());
                $nouvelleEntreprise->setAdresse($donneesEntreprise->getAdresse());
                $nouvelleEntreprise->setActivite($donneesEntreprise->getActivite());

                $manager->persist($nouvelleEntreprise);
                $stage->setEntreprise($nouvelleEntreprise);
            }
            

            $manager->persist($stage);
            $manager->flush();

            return $this->redirectToRoute('ajoutStage');
        }

        return $this->render('pro_stage/ajoutStage.html.twig',
                            ['vueFormulaireAjoutStage' => $formulaireAjoutStage -> createView()]);
    }

}
