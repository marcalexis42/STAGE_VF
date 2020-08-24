<?php

namespace App\Controller;

use App\Entity\DemandeCSE;
use App\Entity\Users;
use App\Form\DemandeCSEType;
use App\Repository\DemandeCSERepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/demandecse")
 */
class DemandeCSEController extends AbstractController
{
    /**
     * @Route("/", name="demandecse_index", methods={"GET"})
     */
    public function index(DemandeCSERepository $demandeCSERepository): Response
    {
        return $this->render('demande_cse/index.html.twig', [
            'demande_c_s_es' => $demandeCSERepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin", name="demandecse_indexadmin", methods={"GET"})
     */
    public function indexadmin(DemandeCSERepository $demandeCSERepository): Response
    {
        return $this->render('demande_cse/indexadmin.html.twig', [
            'demande_c_s_es' => $demandeCSERepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="demandecse_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserInterface $user): Response
    {
        $demandeCSE = new DemandeCSE();
        $demandeCSE -> setCreatedat(new \DateTime('now'));
        $user->getUsername();
        $demandeCSE -> setUser($this->getUser());
        $form = $this->createForm(DemandeCSEType::class, $demandeCSE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demandeCSE);
            $entityManager->flush();

            return $this->redirectToRoute('demandecse_index');
        }

        return $this->render('demande_cse/new.html.twig', [
            'demande_c_s_e' => $demandeCSE,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="demandecse_show", methods={"GET"})
     */
    public function show(DemandeCSE $demandeCSE): Response
    {
        return $this->render('demande_cse/show.html.twig', [
            'demande_c_s_e' => $demandeCSE,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="demandecse_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DemandeCSE $demandeCSE): Response
    {
        $form = $this->createForm(DemandeCSEType::class, $demandeCSE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('demandecse_index');
        }

        return $this->render('demande_cse/edit.html.twig', [
            'demande_c_s_e' => $demandeCSE,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="demandecse_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DemandeCSE $demandeCSE): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demandeCSE->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($demandeCSE);
            $entityManager->flush();
        }

        return $this->redirectToRoute('demandecse_index');
    }
}
