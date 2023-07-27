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
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $module = new Module();

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

    #[Route('/module/{id}/edit', name: 'edit_module')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[ParamConverter('module', options: ['mapping' => ['id' => 'id']])]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $moduleId = $request->get('id');

        $module = $entityManager->getRepository(Module::class)->find($moduleId);

        if (!$module) {
            throw $this->createNotFoundException();
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
