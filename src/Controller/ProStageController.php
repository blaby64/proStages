<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;


class ProStageController extends AbstractController
{

    public function index()
    {
        return $this->render('pro_stage/index.html.twig', [
            'controller_name' => 'ProStageController',
        ]);
    }


    public function afficheBienvenue()
    {
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
        $stages=$repositoryStage->findall();
        return $this->render('pro_stage/accueil.html.twig',['stages'=>$stages]);
    }

    public function afficheEntreprises()
    {
      $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);
      $entreprises=$repositoryEntreprise->findall();
      return $this->render('pro_stage/toute_les_entreprises.html.twig',['entreprises'=>$entreprises]);
    }

    public function afficheFormations()
    {
      $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);
      $formations=$repositoryFormation->findall();
      return $this->render('pro_stage/toute_les_formations.html.twig',['formations'=>$formations]);
    }

    public function afficheId($id)
    {
      $repoStage = $this->getDoctrine()->getRepository(Stage::class);
      $stage = $repoStage->find($id);
      return $this->render('pro_stage/stagesid.html.twig',
      ['stage'=>$stage]);
    }


    public function entreprises($id)
    {
        $repoStage = $this->getDoctrine()->getRepository(Stage::class);
        $stage = $repoStage->findByEntreprise($id);
        return $this->render('pro_stage/entreprises.html.twig',
        ['stages'=>$stage]);
    }

    public function formations($id)
    {
        $repoFormation = $this->getDoctrine()->getRepository(Formation::class);
        $formation = $repoFormation->find($id);
        return $this->render('pro_stage/formations.html.twig',
        ['formation'=>$formation]);
    }
}
