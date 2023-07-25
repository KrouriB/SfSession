<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    #[Route('/session/new', name: 'form_session')]
    #[Route('/session/{id}/edit', name: 'edit_session')]
    public function new(Session $session = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$session){
            $session = new Session();
        }

        $form = $this->createForm(SessionType::class, $session);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = $form->getData();
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('session/form.html.twig', [
            'session' => $form->createView(),
            'edit' => $session->getId()
        ]);
    }

    #[Route('/session/now', name: 'now_session')]
    public function now(SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findCurrentSessionSessionPage();
        return $this->render('session/now.html.twig', [
            'sessions' => $sessions
        ]);
    }
    
    #[Route('/session/futur', name: 'futur_session')]
    public function futur(SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findNextSessionSessionPage();
        return $this->render('session/futur.html.twig', [
            'sessions' => $sessions
        ]);
    }
    
    #[Route('/session/past', name: 'past_session')]
    public function past(SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findPastSessionSessionPage();
        return $this->render('session/past.html.twig', [
            'sessions' => $sessions
        ]);
    }

    #[Route('/session/{id}', name: 'app_session')]
    public function index(Session $session): Response
    {
        $stagiaires = $stagiaireRepository->findBy([],['nom' => 'ASC']);
        $modules = $moduleRepository->findBy([],['nom' => 'ASC']);
        return $this->render('session/index.html.twig', [
            'session' => $session,
            'stagiaires' => $stagiaires,
            'modules' => $modules
        ]);
    }

    #[Route('/session/{id}/addStagiaire', name: 'add_stagiaire')]
    public function addStagiaire(Session $session, Stagiaire $stagiaire, EntityManagerInterface $entityManager): Response
    {
        $session->addStagiaire($stagiaire);

        $entityManager->persist($stagiaire);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_session', ['id' => $session->getId()]);
    }

    #[Route('/session/{id}/deleteStagiaire', name: 'delete_stagiaire')]
    public function deleteStagiaire(Session $session, Stagiaire $stagiaire, EntityManagerInterface $entityManager): Response
    {
        $session->removeStagiaire($stagiaire);

        $entityManager->flush();
        
        return $this->redirectToRoute('app_session', ['id' => $session->getId()]);
    }

    #[Route('/session/{id}/addModule', name: 'add_module')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[ParamConverter('session', class: 'SensioBlogBundle:Post')]
    #[ParamConverter('module', class: 'SensioBlogBundle:Post')]
    public function addModule(Session $session, Module $module, int $nbJours, EntityManagerInterface $entityManager): Response
    {
        $programme = new Programme();
        $programme->setNombreJours($nbJours);

        $module->addProgramme($programme);

        $session->addProgramme($programme);

        $entityManager->persist($programme);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_session', ['id' => $session->getId()]);
    }

    #[Route('/session/{id}/deleteModule', name: 'delete_module')]
    public function deleteModule(Session $session, Programme $programme, EntityManagerInterface $entityManager): Response
    {
        $programme-getModule()->removeProgramme($programme);

        $session->removeProgramme($programme);

        $entityManager->remove($programme);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_session', ['id' => $session->getId()]);
    }
}
