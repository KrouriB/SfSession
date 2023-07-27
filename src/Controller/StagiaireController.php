<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StagiaireController extends AbstractController
{
    #[Route('/stagiaire/new', name: 'form_stagiaire')]
    #[Route('/stagiaire/{id}/edit', name: 'edit_stagiaire')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function new(Stagiaire $stagiaire = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$stagiaire){
            $stagiaire = new Stagiaire();
        }

        $form = $this->createForm(StagiaireType::class, $stagiaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $stagiaire = $form->getData();
            $entityManager->persist($stagiaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('stagiaire/form.html.twig', [
            'stagiaire' => $form->createView(),
            'edit' => $stagiaire->getId()
        ]);
    }


    #[Route('/stagiaire/{id}', name: 'show_stagiaire')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function show(Stagiaire $stagiaire): Response
    {
        $today = date('Y-m-d');
        return $this->render('stagiaire/show.html.twig', [
            'stagiaire' => $stagiaire,
            'today' => $today
        ]);
    }

    


    
    #[Route('/stagiaire', name: 'app_stagiaire')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(StagiaireRepository $stagiaireRepository): Response
    {
        $today = date('Y-m-d');
        $stagiaires = $stagiaireRepository->findBy([],['nom' => 'ASC']);
        return $this->render('stagiaire/index.html.twig', [
            'stagiaires' => $stagiaires,
            'today' => $today
        ]);
    }
}