<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    #[Route('/error404', name: 'error_404')]
    public function error404(): Response
    {
        return $this->render('error/404.html.twig', []);
    }

    #[Route('/error', name: 'app_error')]
    public function index(): Response
    {
        return $this->render(
            'error/index.html.twig', [
                'controller_name' => 'ErrorController',
            ]
        );
    }
}
