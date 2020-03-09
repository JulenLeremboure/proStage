<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    $faker = \Faker\Factory::create('fr_FR');

    $nbEntrepriseParFormation = 2;
    $nbStageParEntreprise = 3;
    $formations = ['DUT Info', 'DUT GIM', 'Licence Pro'];
    $tabActivite = ['Jeux-Video','Service de suivi de garage','Comptabilite'];
    $tabJob = ['Programmation Web','UX Design','Programmation C','Playtest Fortnite'];

    foreach ($formations as $nomFormation) { 

        $formation = new Formation;

        $formation->setNom($nomFormation);

        $manager->persist($formation);

        for ($i=0; $i < $nbEntrepriseParFormation; $i++) {
            $entreprise = new Entreprise();

            $entreprise->setNom($faker->company());
            $entreprise->setAdresse($faker->address());
            $entreprise->setActivite($faker->randomElement($tabActivite));
            //$entreprise->setSite($faker->url);
        
            $manager->persist($entreprise);

            for ($j=0; $j < $nbStageParEntreprise; $j++) { 
                $stage = new Stage();
    
                $stage->setTitre('Stage de '.($faker->randomElement($tabJob)));
                $stage->setDescription($faker->paragraph);
                $stage->setDateDebut($faker->dateTimeBetween($startDate = 'now', //AH
                                $endDate = '+ 1 month', 
                                $timezone = 'Europe/Paris'));
                $stage->setDateFin($faker->dateTimeBetween($startDate = 'now', //AH
                                $endDate = '+ 6 month', 
                                $timezone = 'Europe/Paris'));
                $stage->setEntreprise($entreprise);
                $stage->setMailContact($faker->email()); //AH
                $stage->addFormation($formation);
                
                $manager->persist($stage);
            }
        }

        
    }
    //Création d'une entreprise dans stage
    $entrepriseSansStage = new Entreprise();

    $entrepriseSansStage->setNom('L\'entreprise sans stages');
    $entrepriseSansStage->setAdresse($faker->address());
    $entrepriseSansStage->setActivite($faker->randomElement($tabActivite));

    $manager->persist($entrepriseSansStage);

    $manager->flush();
}
}
