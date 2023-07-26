<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'form_categorie')]
    #[Route('/categorie/{id}/edit', name: 'edit_categorie')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function form(Categorie $categorie = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$categorie){
            $categorie = new Categorie();
        }

        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $categorie = $form->getData();
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('categorie/form.html.twig', [
            'categorie' => $form->createView(),
            'edit' => $categorie->getId()
        ]);
    }
}
