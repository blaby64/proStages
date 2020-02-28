<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Repository\StageRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;


class ProStageController extends AbstractController
{

    public function index()
    {
        return $this->render('pro_stage/index.html.twig', [
            'controller_name' => 'ProStageController',
        ]);
    }

    public function ajouterEntreprise(Request $requetteHttp, ObjectManager $manager)
    {
        $entreprise = new Entreprise();

        $formulaireEntreprise = $this -> createFormBuilder($entreprise)
                                      -> add('nom',TextType::class)
                                      -> add('adresse',TextType::class)
                                      -> add('activite',TextType::class)
                                      -> add('site',UrlType::class)
                                      -> getForm();

        $formulaireEntreprise->handleRequest($requetteHttp);

        if($formulaireEntreprise->isSubmitted()) //&& $formulaireEntreprise->isValid())
        {
            $manager->persist($entreprise);
            $manager->flush();

            return $this->redirectToRoute('proStage_accueil');
        }

        return $this->render('pro_stage/ajoutEntreprise.html.twig', ['vueFormulaireEntreprise' => $formulaireEntreprise->createView()]);
    }

    public function modifierEntreprise(Request $requetteHttp, ObjectManager $manager, Entreprise $entreprise)
    {
        $formulaireEntreprise = $this -> createFormBuilder($entreprise)
                                      -> add('nom', TextType::class)
                                      -> add('adresse', TextType::class)
                                      -> add('activite', TextType::class)
                                      -> add('site', UrlType::class)
                                      -> getForm();

        $formulaireEntreprise->handleRequest($requetteHttp);

        if($formulaireEntreprise->isSubmitted())
        {
            $manager->persist($entreprise);
            $manager->flush();

            return $this->redirectToRoute('proStage_accueil');
        }

        return $this->render('pro_stage/modifierEntreprise.html.twig', ['vueFormulaireEntreprise' => $formulaireEntreprise->createView()]);
    }

    public function afficheBienvenue(StageRepository $repoStage)
    {
        $stages=$repoStage->findAllStages();
        return $this->render('pro_stage/accueil.html.twig',['stages'=>$stages]);
    }

    public function afficheEntreprises(EntrepriseRepository $repoEntreprise)
    {
      $entreprises=$repoEntreprise->findall();
      return $this->render('pro_stage/toute_les_entreprises.html.twig',['entreprises'=>$entreprises]);
    }

    public function afficheFormations(FormationRepository $repoFormation)
    {
      $formations=$repoFormation->findall();
      return $this->render('pro_stage/toute_les_formations.html.twig',['formations'=>$formations]);
    }

    public function afficheId($id, StageRepository $repoStage)
    {
      $stages = $repoStage->find($id);
      return $this->render('pro_stage/stagesid.html.twig',
      ['stage'=>$stages]);
    }

    public function entreprises($nom, StageRepository $repoStage)
    {
        $stages = $repoStage->findByEntreprise($nom);
        return $this->render('pro_stage/entreprises.html.twig',
        ['stages'=>$stages, 'nomEntreprise'=>$nom]);
    }

    public function formations($nom, StageRepository $repoStage)
    {
        $stages = $repoStage->findByFormation($nom);
        return $this->render('pro_stage/formations.html.twig',
        ['stages'=>$stages, 'nomFormation'=>$nom]);
    }
}
