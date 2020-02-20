<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\StageRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;


class ProStageController extends AbstractController
{

    public function index()
    {
        return $this->render('pro_stage/index.html.twig', [
            'controller_name' => 'ProStageController',
        ]);
    }

    public function ajouterEntreprise()
    {
        return $this->render('pro_stage/ajoutEntreprise.html.twig');
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
