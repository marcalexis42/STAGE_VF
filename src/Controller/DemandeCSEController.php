<?php

namespace App\Controller;

use App\Entity\DemandeCSE;
use App\Entity\UserData;
use App\Entity\Users;
use App\Form\DemandeCSEType;
use App\Repository\DemandeCSERepository;
use Doctrine\ORM\Query\AST\Functions\LengthFunction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Length;

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
    public function new(Request $request,\Swift_Mailer $mailer, UserInterface $user): Response
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
            
            //Partie envoi de mail
            
            
            $repository = $this->getDoctrine()->getRepository(UserData::class);

            $receveurs=$repository->findBy(
                ['delegate' => true]
            );
            $emailreceveurs=array();
            foreach($receveurs as $receveur){
                $receptioner=$receveur->getUsers();

                array_push($emailreceveurs, $receptioner->getEmail());
            }
            $demande=$form->getData();
            // On crée le message
            $message = (new \Swift_Message('Nouvelle demande CSE'))
                // On attribue l'expéditeur
                ->setFrom($demandeCSE->getUser()->getEmail())
                // On attribue le destinataire
                    /* foreach($emailreceveurs as $email){
                        ->setTo($email)
                    } */
                ->setTo($emailreceveurs)
                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'emails/demandecse.html.twig', [
                            'demandeur'=>$user,
                            'demande'=>$demande,
                        ]
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);

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
