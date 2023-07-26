<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
    #[Route('/module', name: 'form_module')]
    #[Route('/module/{id}/edit', name: 'edit_module')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function form(Module $module = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$module){
            $module = new Module();
        }

        $form = $this->createForm(ModuleType::class, $module);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $module = $form->getData();
            $entityManager->persist($module);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('module/form.html.twig', [
            'module' => $form->createView(),
            'edit' => $module->getId()
        ]);
    }
}
