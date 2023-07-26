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
    #[ParamConverter('session', options: ['mapping' => ['id' => 'id']])]
    public function index(Session $session, StagiaireRepository $stagiaireRepository, ModuleRepository $moduleRepository, SessionRepository $sessionRepository, int $id): Response
    {
        $stagiaires = $stagiaireRepository->findBy([],['nom' => 'ASC']);
        $modules = $moduleRepository->findBy([],['nom' => 'ASC']);
        $notInStagiaire = $sessionRepository->findStagiaireNotInSession($id);
        $notInModule = $sessionRepository->findModuleNotInSession($id);
        return $this->render('session/index.html.twig', [
            'session' => $session,
            'stagiaires' => $stagiaires,
            'notInStagiaire' => $notInStagiaire,
            'notInModule' => $notInModule,
            'modules' => $modules
        ]);
    }

    #[Route('/session/{id}/addStagiaire/{id_stagiaire}', name: 'add_stagiaire')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[ParamConverter('session', options: ['mapping' => ['id' => 'id']])]
    #[ParamConverter('stagiaire', options: ['mapping' => ['id_stagiaire' => 'id']])]
    public function addStagiaire(Session $session, Stagiaire $stagiaire, EntityManagerInterface $entityManager): Response
    {
        $session->addStagiaire($stagiaire);

        $entityManager->persist($stagiaire);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_session', ['id' => $session->getId()]);
    }

    #[Route('/session/{id}/deleteStagiaire/{id_stagiaire}', name: 'delete_stagiaire')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[ParamConverter('session', options: ['mapping' => ['id' => 'id']])]
    #[ParamConverter('stagiaire', options: ['mapping' => ['id_stagiaire' => 'id']])]
    public function deleteStagiaire(Session $session, Stagiaire $stagiaire, EntityManagerInterface $entityManager): Response
    {
        $session->removeStagiaire($stagiaire);

        $entityManager->flush();
        
        return $this->redirectToRoute('app_session', ['id' => $session->getId()]);
    }

    #[Route('/session/{id}/addModule/{id_module}', name: 'add_module')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[ParamConverter('session', options: ['mapping' => ['id' => 'id']])]
    #[ParamConverter('module', options: ['mapping' => ['id_module' => 'id']])]
    public function addModule(Session $session, Module $module, Request $request, EntityManagerInterface $entityManager): Response
    {
        $programme = new Programme();
        $programme->setNombreJours($request->request->get('nbJours')); //utilisation de la varaible requete ou on peut obtenir le nombre de jours recuperer depuis le form

        $module->addProgramme($programme);

        $session->addProgramme($programme);

        $entityManager->persist($programme);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_session', ['id' => $session->getId()]);
    }

    #[Route('/session/{id}/deleteModule/{id_module}', name: 'delete_module')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[ParamConverter('session', options: ['mapping' => ['id' => 'id']])]
    #[ParamConverter('module', options: ['mapping' => ['id_module' => 'id']])]
    public function deleteModule(Session $session, Programme $programme, EntityManagerInterface $entityManager): Response
    {
        $programme-getModule()->removeProgramme($programme);

        $session->removeProgramme($programme);

        $entityManager->remove($programme);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_session', ['id' => $session->getId()]);
    }
}
