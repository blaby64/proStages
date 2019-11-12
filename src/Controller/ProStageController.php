<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProStageController extends AbstractController
{
    /**
     * @Route("/pro/stage", name="pro_stage")
     */
    public function index()
    {
        return $this->render('pro_stage/index.html.twig', [
            'controller_name' => 'ProStageController',
        ]);
    }

    /**
     * @Route("/", name="pro_stage_accueil")
     */
    public function afficheBienvenue()
    {
        return new Response('<html><body><h1>Bienvenue sur la page d accueil de Prostages</h1></body></html>');
    }

    /**
     * @Route("/entreprises", name="pro_stage_entreprises")
     */
    public function afficheEntreprises()
    {
        return new Response('<html><body><h1>Cette page affichera la liste des entreprises proposant un stage</h1></body></html>');
    }

    /**
     * @Route("/formations", name="pro_stage_formations")
     */
    public function afficheFormations()
    {
        return new Response('<html><body><h1>Cette page affichera la liste des formations de l IUT</h1></body></html>');
    }

    /**
     * @Route("/stages/{id}", name="pro_stage_id")
     */
    public function afficheId()
    {
        return new Response('<html><body><h1>Cette page affichera le descriptif du stage ayant pour identifiant id</h1></body></html>');
    }
}
