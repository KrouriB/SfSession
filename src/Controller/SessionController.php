<?php

namespace App\Controller;

use App\Entity\Session;
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

    #[Route('/session'/*/{id}'*/, name: 'app_session')]
    public function index(/*Session $session*/): Response
    {
        return $this->render('session/index.html.twig', [
            /*formuaire programme + ajout stagiaire*/
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
}
