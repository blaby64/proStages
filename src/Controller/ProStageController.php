<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

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
        return $this->render('pro_stage/accueil.html.twig');
    }

    public function afficheEntreprises()
    {
        return $this->render('pro_stage/entreprises.html.twig');
    }

    public function afficheFormations()
    {
        return $this->render('pro_stage/formations.html.twig');
    }

    public function afficheId($id)
    {
        return $this->render('pro_stage/stagesid.html.twig',['idRessource'=>$id]);
    }
}
