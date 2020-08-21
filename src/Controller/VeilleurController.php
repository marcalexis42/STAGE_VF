<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VeilleurController extends AbstractController
{
    /**
     * @Route("/veilleur", name="veilleur")
     */
    public function index()
    {
        return $this->render('veilleur/index.html.twig', [
            'controller_name' => 'VeilleurController',
        ]);
    }
}
