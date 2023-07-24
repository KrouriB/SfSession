<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
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
}
