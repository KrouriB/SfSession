<?php

namespace App\Controller;

use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Programme;
use App\Entity\Stagiaire;
use App\Form\SessionType;
use App\Repository\ModuleRepository;
use App\Repository\SessionRepository;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SessionController extends AbstractController
{
    #[Route('/session/new', name: 'add_session')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = new Session();

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

    #[Route('/session/{id}/edit', name: 'edit_session')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[ParamConverter('session', options: ['mapping' => ['id' => 'id']])]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sessionId = $request->get('id');

        $session = $entityManager->getRepository(Session::class)->find($sessionId);

        if (!$session) {
            throw $this->createNotFoundException();
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
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function now(SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findCurrentSessionSessionPage();
        return $this->render('session/now.html.twig', [
            'sessions' => $sessions
        ]);
    }
    
    #[Route('/session/futur', name: 'futur_session')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function futur(SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findNextSessionSessionPage();
        return $this->render('session/futur.html.twig', [
            'sessions' => $sessions
        ]);
    }
    
    #[Route('/session/past', name: 'past_session')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function past(SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findPastSessionSessionPage();
        return $this->render('session/past.html.twig', [
            'sessions' => $sessions
        ]);
    }

    #[Route('/session/{id}', name: 'app_session')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[ParamConverter('session', options: ['mapping' => ['id' => 'id']])]
    public function index(StagiaireRepository $stagiaireRepository, ModuleRepository $moduleRepository, SessionRepository $sessionRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

        $sessionId = $request->get('id');

        $session = $entityManager->getRepository(Session::class)->find($sessionId);

        if (!$session) {
            throw $this->createNotFoundException();
        }

        $stagiaires = $stagiaireRepository->findBy([],['nom' => 'ASC']);
        $modules = $moduleRepository->findBy([],['nom' => 'ASC']);
        $notInStagiaire = $sessionRepository->findStagiaireNotInSession($sessionId);
        $notInModule = $sessionRepository->findModuleNotInSession($sessionId);
        return $this->render('session/index.html.twig', [
            'session' => $session,
            'stagiaires' => $stagiaires,
            'notInStagiaire' => $notInStagiaire,
            'notInModule' => $notInModule,
            'modules' => $modules
        ]);
    }

    #[Route('/session/{id_session}/addStagiaire/{id_stagiaire}', name: 'add_stagiaire')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[ParamConverter('session', options: ['mapping' => ['id_session' => 'id']])]
    #[ParamConverter('stagiaire', options: ['mapping' => ['id_stagiaire' => 'id']])]
    public function addStagiaire(Request $request, Session $session, Stagiaire $stagiaire, EntityManagerInterface $entityManager): Response
    {
        $sessionId = $request->get('id_session');

        $session = $entityManager->getRepository(Session::class)->find($sessionId);

        if (!$session) {
            throw $this->createNotFoundException();
        }
        
        $stagiaireId = $request->get('id_stagiaire');

        $stagiaire = $entityManager->getRepository(Stagiaire::class)->find($stagiaireId);

        if (!$stagiaire) {
            throw $this->createNotFoundException();
        }


        $session->addStagiaire($stagiaire);

        $entityManager->persist($stagiaire);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_session', ['id' => $session->getId()]);
    }

    #[Route('/session/{id_session}/deleteStagiaire/{id_stagiaire}', name: 'delete_stagiaire')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[ParamConverter('session', options: ['mapping' => ['id_session' => 'id']])]
    #[ParamConverter('stagiaire', options: ['mapping' => ['id_stagiaire' => 'id']])]
    public function deleteStagiaire(Request $request,  EntityManagerInterface $entityManager): Response
    {
        $sessionId = $request->get('id_session');

        $session = $entityManager->getRepository(Session::class)->find($sessionId);

        if (!$session) {
            throw $this->createNotFoundException();
        }
        
        $stagiaireId = $request->get('id_stagiaire');

        $stagiaire = $entityManager->getRepository(Stagiaire::class)->find($stagiaireId);

        if (!$stagiaire) {
            throw $this->createNotFoundException();
        }

        $session->removeStagiaire($stagiaire);

        $entityManager->flush();
        
        return $this->redirectToRoute('app_session', ['id' => $session->getId()]);
    }

    #[Route('/session/{id_session}/addModule/{id_module}', name: 'add_module')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[ParamConverter('session', options: ['mapping' => ['id' => 'id']])]
    #[ParamConverter('module', options: ['mapping' => ['id_module' => 'id']])]
    public function addModule(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sessionId = $request->get('id_session');

        $session = $entityManager->getRepository(Session::class)->find($sessionId);

        if (!$session) {
            throw $this->createNotFoundException();
        }
        
        $moduleId = $request->get('id_module');

        $module = $entityManager->getRepository(Module::class)->find($moduleId);

        if (!$module) {
            throw $this->createNotFoundException();
        }

        $programme = new Programme();
        $programme->setNombreJours($request->request->get('nbJours')); //utilisation de la varaible requete ou on peut obtenir le nombre de jours recuperer depuis le form

        $module->addProgramme($programme);

        $session->addProgramme($programme);

        $entityManager->persist($programme);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_session', ['id' => $session->getId()]);
    }

    #[Route('/session/{id_session}/deleteModule/{id_programme}/{id_module}', name: 'delete_module')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[ParamConverter('session', options: ['mapping' => ['id_session' => 'id']])]
    #[ParamConverter('module', options: ['mapping' => ['id_module' => 'id']])]
    #[ParamConverter('programme', options: ['mapping' => ['id_programme' => 'id']])]
    public function deleteModule(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sessionId = $request->get('id_session');

        $session = $entityManager->getRepository(Session::class)->find($sessionId);

        if (!$session) {
            throw $this->createNotFoundException();
        }
        
        $moduleId = $request->get('id_module');

        $module = $entityManager->getRepository(Module::class)->find($moduleId);

        if (!$module) {
            throw $this->createNotFoundException();
        }

        $programmeId = $request->get('id_programme');

        $programme = $entityManager->getRepository(Programme::class)->find($programmeId);

        if (!$programme) {
            throw $this->createNotFoundException();
        }

        $module->removeProgramme($programme);

        $session->removeProgramme($programme);

        $entityManager->remove($programme);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_session', ['id' => $session->getId()]);
    }
}
