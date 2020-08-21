<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;

class EspacePersoController extends AbstractController
{
    /**
     * @Route("/perso", name="espace_perso")
     */
    public function index()
    {

      $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
      $user = $this->getUser();

        if ($user == null) {
          return $this->render('security/login.html.twig');
        }

        else {
          return $this->render('espace_perso/index.html.twig');
        }

    }
}
