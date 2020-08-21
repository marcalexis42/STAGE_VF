<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Topics;
use App\Entity\Commentaires;
use App\Form\TopicsType;
use App\Form\CommentairesType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class ForumController extends AbstractController
{
    /**
     * @Route("/forum", name="forum")
     */
    public function index()
    {
        $topics = $this->getDoctrine()->getRepository(Topics::class)->findBy([],['edited_at'=>'desc']);
        return $this->render('forum/index.html.twig', [
            'topics' => $topics,
        ]);
    }

    /**
     * @Route("/forum/topic", name="forum_topic")
     */
    public function submit(Request $request):Response
    {
      $topic=new Topics();
      $topic->setEditedAt(new \DateTime('now'));
      $topic->setAuthor($this->getUser());
      $topic->setMsgCounter(1);
      $topic->setPin(0);
      $form=$this->createForm(TopicsType::class, $topic);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($topic);
            $entityManager->flush();

            return $this->render('forum/topic_vue.html.twig',[
              'topic' => $topic
            ]);
      }
          return $this->render('forum/topic_creation.html.twig',[
              'topicsForm' => $form->createView(),
          ]);
    }

    /**
     * @Route("/forum/topic/{topicId}", name="forum_topic_vue")
     */
    public function look(Request $request, int $topicId):Response
    {
      $entityManager = $this->getDoctrine()->getManager();
      $topic =$entityManager->getRepository(Topics::class)->find($topicId);

          return $this->render('forum/topic_vue.html.twig',[
              'topic' => $topic
            ]);
    }


    /**
     * @Route("/forum/topic_edition/{topicId}", name="forum_topic_edition")
     */
    public function edition(Request $request, int $topicId):Response
    {
      $entityManager = $this->getDoctrine()->getManager();
      $topic =$entityManager->getRepository(Topics::class)->find($topicId);

      $form=$this->createForm(TopicsType::class, $topic);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($topic);
            $entityManager->flush();

            return $this->render('forum/topic_vue.html.twig',[
              'topic' => $topic

            ]);
      }
          return $this->render('forum/topic_edition.html.twig',[
              'topicsForm' => $form->createView(),
              'topic' => $topic
          ]);
    }


    /**
     * @Route("/forum/commentaire", name="forum_commentaire")
     */
    public function commentaire(Request $request):Response
    {
      $commentaire=new Commentaires();
      $commentaire->setCreatedAt(new \DateTime('now'));
      $commentaire->setEditedAt(new \DateTime('now'));
      $commentaire->setAuthor($this->getUser());
      $id = 2;
      $topic =  $this->getDoctrine()->getRepository(Topics::class)->findAll();
      $topic = $topic[0];
      echo($topic->getId());
      $subject = $topic->getSubject();
      $commentaire->setSubject($subject);

      $form=$this->createForm(commentairesType::class, $commentaire);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('forum');
      }
          return $this->render('forum/commentaire.html.twig',[
              'commentairesForm' => $form->createView(),
          ]);
    }
}
