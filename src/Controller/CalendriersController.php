<?php

namespace App\Controller;

use App\Entity\Calendriers;
use App\Form\CalendriersType;
use App\Entity\Users;
use App\Repository\CalendriersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/calendriers")
 */
class CalendriersController extends AbstractController
{
    /**
     * @Route("/", name="calendriers_index", methods={"GET"})
     */
    public function index(CalendriersRepository $calendriersRepository): Response
    {
        $calendrier = $calendriersRepository->findBy([],
            [ 'start' => 'desc' ]
          );
        return $this->render('calendriers/index.html.twig', [
            'calendriers' => $calendrier
          ]);
    }

    /**
     * @Route("/new", name="calendriers_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $calendrier = new Calendriers();

          $calendrier->setBackgroundColor('#ff2d00');
          $calendrier->setBorderColor('#ffffff');
          $calendrier->setTextColor('#000000');


        $form = $this->createForm(CalendriersType::class, $calendrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($calendrier);
            $entityManager->flush();

            return $this->redirectToRoute('calendriers_index');
        }

        return $this->render('calendriers/new.html.twig', [
            'calendrier' => $calendrier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="calendriers_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Calendriers $calendrier): Response
    {
        $form = $this->createForm(CalendriersType::class, $calendrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('calendriers_index');
        }

        return $this->render('calendriers/edit.html.twig', [
            'calendrier' => $calendrier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="calendriers_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Calendriers $calendrier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$calendrier->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($calendrier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('calendriers_index');
    }
}
