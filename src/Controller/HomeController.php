<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(SessionRepository $sessionRepository): Response
    {
        $past = $sessionRepository->findPastSessionHomePage();
        $now = $sessionRepository->findCurrentSessionHomePage();
        $futur = $sessionRepository->findFuturSessionHomePage();
        return $this->render('home/index.html.twig', [
            'past' => $past,
            'now' => $now,
            'futur' => $futur
        ]);
    }
}
