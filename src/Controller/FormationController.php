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
    #[Route('/formation', name: 'add_formation')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $formation = new Formation();

        $form = $this->createForm(FormationType::class, $formation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formation = $form->getData();
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render(
            'formation/form.html.twig',
            [
                'formation' => $form->createView(),
                'edit' => $formation->getId()
            ]
        );
    }

    #[Route('/formation/{id}/edit', name: 'edit_formation')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[ParamConverter('formation', options: ['mapping' => ['id' => 'id']])]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $formationId = $request->get('id');

        $formation = $entityManager->getRepository(Formation::class)->find($formationId);

        if (!$formation) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(FormationType::class, $formation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formation = $form->getData();
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render(
            'formation/form.html.twig',
            [
                'formation' => $form->createView(),
                'edit' => $formation->getId()
            ]
        );
    }
}
