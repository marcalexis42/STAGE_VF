<?php

namespace App\Controller;

use App\Entity\CR;
use App\Form\CRType;
use App\Repository\CRRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * @Route("/cr")
 */
class CRController extends AbstractController
{
    /**
     * @Route("/", name="c_r_index", methods={"GET"})
     */
    public function index(CRRepository $cRRepository): Response
    {
        return $this->render('cr/index.html.twig', [
            'c_rs' => $cRRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="c_r_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cR = new CR();
        $cR ->setCreatedAt(new \DateTime('now'));
        $form = $this->createForm(CRType::class, $cR);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

          // $file stores the uploaded PDF file
           /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
           $file = $cR->getFilename();

           $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

           // moves the file to the directory where brochures are stored
           $file->move(
               $this->getParameter('CR_directory'),
               $fileName
           );

           // updates the 'brochure' property to store the PDF file name
           // instead of its contents
           $cR->setFilename($fileName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cR);
            $entityManager->flush();

            return $this->redirectToRoute('c_r_index');
        }

        return $this->render('cr/new.html.twig', [
            'c_r' => $cR,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * @Route("/{id}", name="c_r_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CR $cR): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cR->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cR);
            $entityManager->flush();
        }

        return $this->redirectToRoute('c_r_index');
    }
}