<?php

namespace App\Controller\Admin;

use App\Entity\Dish;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
       
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Gestion du restaurant <br> Q U A I _ A N T I Q U E');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('D A S H B O A R D', 'fa fa-home');
        yield MenuItem::linkToCrud('Les Utilisateurs', 'fa fa-user-o', User::class);
        yield MenuItem::linkToCrud('Les Plats', 'fa fa-cutlery', Dish::class);
    }
}
