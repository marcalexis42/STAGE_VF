<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Demande;
use App\Entity\Users;
use App\Form\DemandeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class ComptableController extends AbstractController
{
    /**
     * @Route("/comptabilite", name="comptabilite")
     */
    public function index()
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findBy([],['created_at'=>'desc']);
        return $this->render('comptable/index.html.twig', [
            'controller_name' => 'ComptableController',
            'demandes' => $demandes,
        ]);
    }
    /**
     * @Route("/comptabilite/comptable", name="comptableadmin")
     */
    public function indexadmin()
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findBy([],['created_at'=>'desc']);
        return $this->render('comptable/indexadmin.html.twig', [
            'controller_name' => 'ComptableController',
            'demandes' => $demandes,
        ]);
    }
    /**
     * @Route("/comptabilite/demande", name="demandecompta")
     */
    public function submit(Request $request):Response
    {
        $demande=new Demande();
        /* $user=$this->getUsers(); */
        $form=$this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demande);
            $entityManager->flush();

            return $this->redirectToRoute('comptabilite');
        }

        return $this->render('comptable/demande.html.twig', [
            'DemandeForm' => $form->createView(),
        ]);
    }
}
