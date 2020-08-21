<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index()
    {
        //dump($this=getUser()->getUsername());
        //$username=getUsername($user);
        //dump($username->getUsername(getUsers()));
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            //'username' => $user
            ]);
    }
}
