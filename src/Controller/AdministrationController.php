<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CalendriersRepository;

class AdministrationController extends AbstractController
{
    /**
     * @Route("/direction", name="direction")
     */
     public function index(calendriersRepository $calendar)
     {
       $events = $calendar->findBy(
           [ 'espace' => 'administration' ]
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

             return $this->render('direction/index.html.twig'  , compact('data'));
     }
}
