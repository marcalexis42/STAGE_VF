<?php

namespace App\Controller;

use App\Entity\DemandeComptable;
use App\Entity\UserData;
use App\Entity\Users;
use App\Form\DemandeComptableType;
use App\Repository\DemandeComptableRepository;
use App\Repository\UserDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

/**
 * @Route("/comptable")
 */
class DemandeComptableController extends AbstractController
{
    /**
     * @Route("/", name="demande_comptable_index", methods={"GET"})
     */
    public function index(DemandeComptableRepository $demandeComptableRepository): Response
    {
        return $this->render('demande_comptable/index.html.twig', [
            'demande_comptables' => $demandeComptableRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin", name="demande_comptable_indexadmin", methods={"GET"})
     */
    public function indexadmin(DemandeComptableRepository $demandeComptableRepository): Response
    {
        return $this->render('demande_comptable/indexadmin.html.twig', [
            'demande_comptables' => $demandeComptableRepository->findAll(),
        ]);
    }

    /**
     * @Route("/salarie", name="demande_comptable_salarie", methods={"GET"})
     */
    public function indexsalarie(UserDataRepository $userDataRepository): Response
    {
        return $this->render('demande_comptable/indexsalarie.html.twig', [
            'user_datas' => $userDataRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="demande_comptable_new", methods={"GET","POST"})
     */
    public function new(Request $request,\Swift_Mailer $mailer, UserInterface $user): Response
    {
        $demandeComptable = new DemandeComptable();
        $demandeComptable -> setCreatedat(new \DateTime('now'));
        $user->getUsername();
        $demandeComptable -> setUser($user);

        $form = $this->createForm(DemandeComptableType::class, $demandeComptable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demandeComptable);
            $entityManager->flush();
            $this->addFlash('message', 'Votre demande a été transmise.'); // Permet un message flash de renvoi

            $repository = $this->getDoctrine()->getRepository(UserData::class);

            $receveurs=$repository->findBy(
                ['poste' => ['Comptable','Direction']]
            );
            $emailreceveurs=array();
            foreach($receveurs as $receveur){
                $receptioner=$receveur->getUsers();

                array_push($emailreceveurs, $receptioner->getEmail());
            }
            $demande=$form->getData();
            // On crée le message
            $message = (new \Swift_Message('Nouvelle demande Comptable'))
                // On attribue l'expéditeur
                ->setFrom($demandeComptable->getUser()->getEmail())
                // On attribue le destinataire
                    /* foreach($emailreceveurs as $email){
                        ->setTo($email)
                    } */
                ->setTo($emailreceveurs)
                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'emails/demandecomptable.html.twig', [
                            'demandeur'=>$user,
                            'demande'=>$demande,
                        ]
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);


            return $this->redirectToRoute('demande_comptable_index');
        }
        //Partie envoi de mail

        return $this->render('demande_comptable/new.html.twig', [
            'demande_comptable' => $demandeComptable,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="demande_comptable_show", methods={"GET"})
     */
    public function show(DemandeComptable $demandeComptable): Response
    {
        return $this->render('demande_comptable/show.html.twig', [
            'demande_comptable' => $demandeComptable,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="demande_comptable_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DemandeComptable $demandeComptable): Response
    {
        $form = $this->createForm(DemandeComptableType::class, $demandeComptable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('demande_comptable_index');
        }

        return $this->render('demande_comptable/edit.html.twig', [
            'demande_comptable' => $demandeComptable,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="demande_comptable_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DemandeComptable $demandeComptable): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demandeComptable->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($demandeComptable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('demande_comptable_index');
    }
    /**
     * @Route("/{id}/accept", name="demande_comptable_accept", methods={"GET","POST"})
     */
    public function approuverRdvAction(Request $request, DemandeComptable $demande/* , UserData $userdata */): Response
    {
        $em = $this->getDoctrine()->getManager();
        
        
        $demande->acceptdemande();
        $demandeur=$demande->getUser();
        $userdata=$demandeur->getUserData();
        
        
        $donneesdemande=array(
            'récup'=>$demande->getHoursrequest(),
            'supp'=>$demande->getHourssupp(), 
            'congés'=>$demande->getHolidaysrequest()
        );
        $donneesuser=array(
            'heures'=>$userdata->getHours(), 
            'jours'=>$userdata->getHolidays()
        );
        
        $donneesuser['heures']=$donneesuser['heures']-$donneesdemande['récup']+$donneesdemande['supp'];
        $donneesuser['jours']=$donneesuser['jours']-$donneesdemande['congés'];
        
        $userdata->setHours($donneesuser['heures']);        
        $userdata->setHolidays($donneesuser['jours']);
        
        $em->flush();
        
        return $this->redirectToRoute('demande_comptable_indexadmin');
        /* return $this->render('test.html.twig', [
            'donneesdemande' => $donneesdemande,
            'donneesuser'=>$donneesuser,
            'demande'=>$demande,
            'demandeur'=>$demandeur,
            'userdata'=>$userdata,
            'userdataid'=>$userdataid,
            'userid'=>$userid,
            
        ]); */
        
    }

    /**
     * @Route("/{id}/refuse", name="demande_comptable_refuse", methods={"GET","POST"})
     */
    public function refuser(Request $request, DemandeComptable $demande): Response
    {
        $em = $this->getDoctrine()->getManager();
        $demande->refusedemande();

        $em->flush();
        return $this->redirectToRoute('demande_comptable_indexadmin');
    }       
}
