<?php

namespace App\Controller;

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
}
