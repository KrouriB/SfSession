<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'add_categorie')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorie = $form->getData();
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render(
            'categorie/form.html.twig',
            [
                'categorie' => $form->createView(),
                'edit' => $categorie->getId()
            ]
        );
    }

    #[Route('/categorie/{id}/edit', name: 'edit_categorie')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorieId = $request->get('id');

        $categorie = $entityManager->getRepository(Categorie::class)->find($categorieId);

        if (!$categorie) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorie = $form->getData();
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render(
            'categorie/form.html.twig',
            [
                'categorie' => $form->createView(),
                'edit' => $categorie->getId()
            ]
        );
    }
}
