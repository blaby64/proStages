<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Formation;
use App\Entity\Entreprise;
use App\Entity\Stage;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR'); // Créer un faker français
        //Création des formations
        $formationDUTInfo = new Formation();
        $formationLPProg = new Formation();
        $formationDUTIC = new Formation();
        $formationDUTInfo->setNom("DUT Informatique");
        $formationDUTInfo->setNomLong("Diplome universitaire de technologie informatique");
        $formationLPProg->setNom("LP Prog avancée");
        $formationLPProg->setNomLong("Licence professionnel programmation avancée");
        $formationDUTIC->setNom("DUT TIC");
        $formationDUTIC->setNomLong("Diplome universitaire des technologies de l'information et de la communication");
        $tabFormations = array($formationDUTInfo,$formationDUTIC,$formationLPProg);
        $manager->persist($formationDUTInfo);
        $manager->persist($formationDUTIC);
        $manager->persist($formationLPProg);

        //Création des entreprises
        $tabEntreprises = array();
        for($i = 0; $i < 5 ; $i++)
        {
            $entreprise = new Entreprise();
            $nomEntr=$faker->company();
            $nomSansSpeciaux = str_replace('.','',$nomEntr);
            $nomSansEspaces = str_replace(' ','',$nomSansSpeciaux);
            $entreprise->setNom($nomEntr);
            $entreprise->setAdresse($faker->address());
            $entreprise->setActivite($faker->jobtitle());
            $entreprise->setSite($nomSansEspaces.$faker->regexify('\.(fr|es|com)'));
            array_push($tabEntreprises,$entreprise);
            $manager->persist($entreprise);
        }
        //Création des stages
        foreach($tabEntreprises as $stageEntr)
        {
            for ($i=0; $i < 3; $i++)
            {
                $stage = new Stage();
                $nbFormations = $faker->numberBetween(1,3); // Génération d'un nombre aléatoire pour définir le nombre de formations concernées apr le stage
                switch($nbFormations)
                {
                    case 1:
                    $choixFormation = $faker->numberBetween(0,2); // Génération d'un nombre aléatoire pour définir la formation qui concernera le stage
                    $stage->addFormation($tabFormations[$choixFormation]);
                    $tabFormations[$choixFormation]->addStage($stage);
                    $manager->persist($tabFormations[$choixFormation]);
                    break;
                    case 2:
                    $choixFormation1 = $faker->numberBetween(0,2); // Génération de deux nombres aléatoire pour définir les formations qui concerneront le stage
                    $choixFormation2 = $faker->numberBetween(0,2);
                    while($choixFormation1 == $choixFormation2) // Si les nombres générés sont identiques, en regénère un jusqu'à ce qu'il soit différent
                    {
                        $choixFormation2 = $faker->numberBetween(0,2);
                    }
                    $stage->addFormation($tabFormations[$choixFormation1]);
                    $tabFormations[$choixFormation1]->addStage($stage);
                    $stage->addFormation($tabFormations[$choixFormation2]);
                    $tabFormations[$choixFormation2]->addStage($stage);
                    $manager->persist($tabFormations[$choixFormation1]);
                    $manager->persist($tabFormations[$choixFormation2]);
                    break;
                    case 3:
                    foreach($tabFormations as $uneFormation)
                    {
                        $stage->addFormation($uneFormation);
                        $uneFormation->addStage($stage);
                        $manager->persist($uneFormation);
                    }
                    break;
                }
                $stage->setTitre($faker->jobtitle());
                $stage->setEmail("contact".$faker->firstname()."@".$stageEntr->getsite());
                $stage->setDescription($faker->realtext(255));
                $stage->setEntreprise($stageEntr);
                $stageEntr->addStage($stage);
                $manager->persist($stageEntr);
                $manager->persist($stage);
            }
        }
        $manager->flush();
    }
}
