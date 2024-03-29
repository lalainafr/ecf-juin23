<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Repository\DishRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DishController extends AbstractController
{

    #[Route('/carte', name: 'app_dish')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findAll();
        return $this->render('pages/dish/index.html.twig', [
            'categories' => $category,
        ]);
    }

    #[Route('/carte/{slug}', name: 'app_dish_show')]
    public function show($slug, DishRepository $dishRepository): Response
    {
        $dish = $dishRepository->findOneBy(["slug" => $slug]);
        return $this->render('pages/dish/show.html.twig', [
            'dish' => $dish,
        ]);
    }
}
