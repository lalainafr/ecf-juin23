<?php

namespace App\Controller\Admin;

use App\Entity\Dish;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Formula;
use App\Entity\Menu;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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
            ->setTitle('Gestion - Quai Antique ');
    }

    public function configureMenuItems(): iterable
    {   
        
        yield MenuItem::subMenu('Utisateurs', 'fa fa-user-o')->setSubItems([
            MenuItem::linkToCrud('Créer un Utilisateur', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher les Utilisateurs', 'fas fa-eye', User::class),
        ]);
        yield MenuItem::subMenu('Plats', 'fa fa-cutlery')->setSubItems([
            MenuItem::linkToCrud('Créer un Plat', 'fas fa-plus', Dish::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher les Plats', 'fas fa-eye', Dish::class),
        ]);
        yield MenuItem::subMenu('Categories', 'fa fa-toggle-on')->setSubItems([
            MenuItem::linkToCrud('Créer une catégorie', 'fas fa-plus', Category::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher des catégories', 'fas fa-eye', Category::class),
        ]);
        yield MenuItem::subMenu('Menu', 'fa fa-toggle-on')->setSubItems([
            MenuItem::linkToCrud('Créer un Menu', 'fas fa-plus', Menu::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher des Menus', 'fas fa-eye', Menu::class),
        ]);
        yield MenuItem::subMenu('Formules', 'fa fa-toggle-on')->setSubItems([
            MenuItem::linkToCrud('Créer une formules', 'fas fa-plus', Formula::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher des formules', 'fas fa-eye', Formula::class),
        ]);


    }
}
