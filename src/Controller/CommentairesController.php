<?php

namespace App\Controller;

use App\Entity\Commentaires;
use App\Form\CommentairesType;
use App\Entity\Topics;
use App\Repository\CommentairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commentaires")
 */
class CommentairesController extends AbstractController
{

    /**
     * @Route("/{topicId}/new", name="commentaires_new", methods={"GET","POST"})
     */
    public function new(Request $request, int $topicId): Response
    {
        $topic =$this->getDoctrine()->getRepository(Topics::class)->find($topicId);
        $topic -> setEditedAt(new \DateTime('now'));
        $commentaire = new Commentaires();
        $commentaire->setEditedAt(new \DateTime('now'));
        $commentaire->setCreatedAt(new \DateTime('now'));
        $commentaire->setAuthor($this->getUser());
        $commentaire->setSubject($topic);


        $form = $this->createForm(CommentairesType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('topics_show' , ['id' => $topicId ] );
        }

        return $this->render('commentaires/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{topicId}/{id}/edit", name="commentaires_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Commentaires $commentaire, int $topicId ): Response
    {
        $form = $this->createForm(CommentairesType::class, $commentaire);
        $form->handleRequest($request);
        $commentaire->setEditedAt(new \DateTime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('topics_show' , ['id' => $topicId ]);
        }

        return $this->render('commentaires/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{topicId}/{id}", name="commentaires_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Commentaires $commentaire, int $topicId ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('topics_show' , ['id' => $topicId ]);
    }
}
