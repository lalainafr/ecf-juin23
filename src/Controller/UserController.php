<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\ReservationsRepository;
use ContainerYnw6cDQ\getReservationsService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserController extends AbstractController
{
    // Seul un utilisateur connecté  pourra consulter les réservations dont il est le propriétaire
    #[Security("is_granted('ROLE_USER') and user.getSlug() === slug")]
    #[Route('/reservations/{slug}', name: 'app_user_reservations')]
    public function UserReservation(UserRepository $repo, $slug, ReservationsRepository $reservationsRepository): Response
    {
        $user = $repo->findOneBy(["slug" => $slug]);
        $reservations =  $reservationsRepository->findBy(['user' => $this->getUser()]);
        $allergies = $this->getArrayAllergies($user);

        return $this->render('pages/user/index.html.twig', [
            'reservations' => $reservations,
            'allergies' => $allergies,
        ]);
    }

    // Seul un utilisateur connecté  pourra consulter le profil dont il est le propriétaire
    #[Security("is_granted('ROLE_USER') and user.getSlug() === slug")]
    #[Route('/profile/{slug}', name: 'app_user_profile')]
    public function UserProfile(UserRepository $repo, $slug): Response
    {
        $user = $repo->findOneBy(["slug" => $slug]);
        $allergies = $this->getArrayAllergies($user);

        return $this->render('pages/user/profile.html.twig', [
            'user' => $user,
            'allergies' => $allergies,
        ]);
    }

    public function getArrayAllergies($user){
        $allergies = [];
        for ($i=0; $i < count($user->getAllergies()); $i++) { 
            $allergies[] = $user->getAllergies()->getValues()[$i]->getName();
        }
        return $allergies;
    }
}

