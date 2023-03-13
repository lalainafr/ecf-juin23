<?php

namespace App\Controller;

use App\Repository\UserRepository;
use ContainerYnw6cDQ\getReservationsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/reservations', name: 'app_user_reservations')]
    public function UserReservation(): Response
    {
        $reservations =  $this->getUser()->getReservations();
      
        return $this->render('pages/user/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/user/profile', name: 'app_user_profile')]
    public function UserProfile(UserRepository $repo): Response
    {
        
        $id = $this->getUser()->getId();
        $user = $repo->findOneBy(["id" => $id]);
        return $this->render('pages/user/profile.html.twig', [
            'user' => $user,
        ]);
    }
}
