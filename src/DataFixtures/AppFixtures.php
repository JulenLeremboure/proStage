<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App/Entity/Entreprise;
use App/Entity/Formation;
use App/Entity/Stage;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR')

    $nbEntrepriseParFormation = 2;
    $nbStageParEntreprise = 3;
    $formations = ['DUT Info', 'DUT GIM', 'Licence Pro']

    for ($formations as $nomFormation) { 

        $formation = new Formation;

        $formation->setNom($nomFormation);
        $manager->persist($formation);

        for ($i=0; $i < $nbEntrepriseParFormation; $i++) {//2 Entreprises proposent des stages pour une formation
            $entreprise = new Entreprise();

            $entreprise->setNom($faker->regexify('A|E|I|O|U).(G|T|C|M|X).(A|E|I|O|U).
                                            (P|L|S|N|B).(A|E|I|O|U).(C|P|T|S).(H|R|L).
                                            (A|E|I|O|U)'));
            $entreprise->setAdresse($entreprise->getNom().'@gmail.com');
            $entreprise->setActivite($faker->regexify('(Jeux-video)|(Service de suivi de garage)|(Comptabilite)');
            $entreprise->setSite($faker->url);
        
            $manager->persist($entreprise);

            for ($i=0; $i < $nbStageParEntreprise; $i++) { 
                $stage = new Stage();
    
                $stage->setTitre($faker->regexify('(Stage de).((Programmation Web)|(Web Design)|(Programmation Java)|(Playtest Fortnite)');;
                $stage->setDescription($faker->paragraph);
                $stage->setDateDebut($faker->dateTimeBetween($startDate = 'now', //AH
                                $endDate = '+ 1 month', 
                                $timezone = 'Europe/Paris');
                $stage->setDateFin($faker->dateTimeBetween($startDate = 'now', //AH
                                $endDate = '+ 6 month', 
                                $timezone = 'Europe/Paris');
                $stage->setEntreprise();
                $stage->setContact(getEntreprise()->getNom().'@gmail.com')); //AH
                
                $manager->persist($stage);
            }
        }

        

        $manager->flush();
    }
}
