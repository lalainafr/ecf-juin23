<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Repository\DishRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DishController extends AbstractController
{

    #[Route('/carte', name: 'app_dish')]
    public function index(DishRepository $dishRepository): Response
    {
        $dishes = $dishRepository->findAll();
        return $this->render('pages/dish/index.html.twig', [
            'dishes' => $dishes,
        ]);
    }
    
    #[Route('/carte/{id}', name: 'app_dish_show')]
    public function show(int $id, DishRepository $dishRepository): Response
    {
        $dish = $dishRepository->findOneById($id);
        return $this->render('pages/dish/show.html.twig', [
            'dish' => $dish,
        ]);
    }
}
