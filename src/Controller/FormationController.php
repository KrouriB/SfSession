<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
    #[Route('/formation', name: 'form_formation')]
    #[Route('/formation/{id}/edit', name: 'edit_formation')]
    public function form(Formation $formation = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$formation){
            $formation = new Formation();
        }

        $form = $this->createForm(FormationType::class, $formation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $formation = $form->getData();
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('formation/form.html.twig', [
            'formation' => $form->createView(),
            'edit' => $formation->getId()
        ]);
    }
}
