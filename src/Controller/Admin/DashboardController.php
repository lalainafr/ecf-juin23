<?php

namespace App\Controller\Admin;

use App\Entity\Availability;
use App\Entity\Dish;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Formula;
use App\Entity\Menu;
use App\Entity\Open;
use App\Entity\Reservations;
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
        yield MenuItem::subMenu('UTILISATEURS', 'fa fa-user-o')->setSubItems([
            MenuItem::linkToCrud('Créer un Utilisateur', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher les Utilisateurs', 'fas fa-eye', User::class),
        ]);
        yield MenuItem::subMenu('PLATS', 'fa fa-cutlery')->setSubItems([
            MenuItem::linkToCrud('Créer un Plat', 'fas fa-plus', Dish::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher les Plats', 'fas fa-eye', Dish::class),
        ]);
        yield MenuItem::subMenu('MENU', 'fas fa-hamburger')->setSubItems([
            MenuItem::linkToCrud('Créer un Menu', 'fas fa-plus', Menu::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher des Menus', 'fas fa-eye', Menu::class),
        ]);
        yield MenuItem::subMenu('CATEGORIES', 'fas fa-list')->setSubItems([
            MenuItem::linkToCrud('Créer une catégorie', 'fas fa-plus', Category::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher des catégories', 'fas fa-eye', Category::class),
        ]);
        yield MenuItem::subMenu('FORMULES', 'fa fa-toggle-on')->setSubItems([
            MenuItem::linkToCrud('Créer une formules', 'fas fa-plus', Formula::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher des formules', 'fas fa-eye', Formula::class),
        ]);
        yield MenuItem::subMenu('HORAIRE D\'OUVERTURE', 'fa-regular fa-clock')->setSubItems([
            MenuItem::linkToCrud('Créer une horaire', 'fas fa-plus', Open::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher les horaires', 'fas fa-eye', Open::class)
        ]);
        yield MenuItem::subMenu('DISPONIBILITE', 'fa fa-times')->setSubItems([
            MenuItem::linkToCrud('Créer une disponibilité', 'fas fa-plus', Availability::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher les disponibilités', 'fas fa-eye', Availability::class),        ]);
    }
}
