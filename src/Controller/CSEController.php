<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Demande;
use App\Entity\Users;
use App\Form\DemandeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CSEController extends AbstractController
{
    /**
     * @Route("/cse", name="cse")
     */
    public function index()
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findBy([],['created_at'=>'desc']);
        return $this->render('cse/index.html.twig', [
            'controller_name' => 'CSEController',
            'demandes' => $demandes,
        ]);
    }
    /**
     * @Route("/cse/delegue", name="cse_admin")
     */
    public function indexadmin()
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findBy([],['created_at'=>'desc']);
        return $this->render('cse/index_admin.html.twig', [
            'controller_name' => 'CSEController',
            'demandes' => $demandes,
        ]);
    }
    /**
     * @Route("/cse/demande", name="cse_demande")
     */
    public function submit(Request $request):Response
    {
        $demande=new Demande();
        $demande->setObject('Demande CSE');
        $demande->setCreatedAt(new \DateTime('now'));
        $demande->setEditor($this->getUser());
        $form=$this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demande);
            $entityManager->flush();

            return $this->redirectToRoute('cse');
        }

        return $this->render('cse/demande.html.twig', [
            'DemandeForm' => $form->createView(),
        ]);
    }
    /* public function article($slug)
    {
    // On récupère l'article correspondant au slug
        $article = $this->getDoctrine()->getRepository(Articles::class)->findOneBy(['slug' => $slug]);

    // On récupère les commentaires actifs de l'article
        $commentaires = $this->getDoctrine()->getRepository(Commentaires::class)->findBy([
            'articles' => $article,
            'actif' => 1
            ],['created_at' => 'desc']);

        if(!$article){
        // Si aucun article n'est trouvé, nous créons une exception
        throw $this->createNotFoundException('L\'article n\'existe pas');
        }

        // Si l'article existe nous envoyons les données à la vue
        return $this->render('articles/article.html.twig', compact('article', 'commentaires'));
} */
}
