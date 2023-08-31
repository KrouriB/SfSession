<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Categorie;
use App\Entity\Formation;
use App\Entity\Programme;
use App\Entity\Stagiaire;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\SessionCrudController;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(SessionCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('SfSession');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Sessions', 'fas fa-users-rectangle', Session::class);
        yield MenuItem::linkToCrud('Stagiaires', 'fas fa-users', Stagiaire::class);
        yield MenuItem::linkToCrud('Programmes', 'fas fa-calendar', Programme::class);
        yield MenuItem::linkToCrud('Modules', 'fas fa-clipboard', Module::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-table-cells-large', Categorie::class);
        yield MenuItem::linkToCrud('Formations', 'fas fa-list', Formation::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-users-gear', User::class);
    }
}
