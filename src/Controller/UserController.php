<?php

namespace App\Controller;

use App\Repository\UserRepository;
use ContainerYnw6cDQ\getReservationsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/reservations/{slug}', name: 'app_user_reservations')]
    public function UserReservation(UserRepository $repo, $slug): Response
    {
        $user = $repo->findOneBy(["slug" => $slug]);
        $reservations =  $user->getReservations();
      
        return $this->render('pages/user/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/profile/{slug}', name: 'app_user_profile')]
    public function UserProfile(UserRepository $repo, $slug): Response
    {
        $user = $repo->findOneBy(["slug" => $slug]);
        
        return $this->render('pages/user/profile.html.twig', [
            'user' => $user,
        ]);
    }
}
