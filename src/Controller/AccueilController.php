<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;
use App\Repository\CalendriersRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(calendriersRepository $calendar)
    {
      $events = $calendar->findBy(
          [ 'espace' => 'commun' ]
        );
              $rdvs = [];

              foreach($events as $event){
                  $rdvs[] = [
                      'id' => $event->getId(),
                      'start' => $event->getStart()->format('Y-m-d H:i:s'),
                      'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                      'title' => $event->getTitle(),
                      'description' => $event->getDescription(),
                      'backgroundColor' => $event->getBackgroundColor(),
                      'borderColor' => $event->getBorderColor(),
                      'textColor' => $event->getTextColor(),
                      'allDay' => $event->getAllDay(),
                  ];
              }

              $data = json_encode($rdvs);

              return $this->render('accueil/index.html.twig', compact('data'));
    }
}
