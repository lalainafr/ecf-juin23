<?php

namespace App\Controller;

use App\Entity\Availability;
use App\Entity\Reservations;
use App\Form\ReservationsType;
use App\Repository\ReservationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationsController extends AbstractController
{
    #[Route('/reservations', name: 'app_reservations')]
    public function index(Request $resquest, EntityManagerInterface $em): Response
    {
        $reservations = new Reservations();
        $form = $this->createForm(ReservationsType::class, $reservations);
        $form->handleRequest($resquest);
        if($form->isSubmitted() && $form->isValid()){
            $reservation = $form->getData();
            $em->persist($reservation);
            $em->flush();
            return $this->redirectToRoute('app_reservations');
        }

        return $this->render('pages/reservations/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reservations/liste', name: 'app_reservations_list')]
    public function list(ReservationsRepository $repo): Response
    {
        $reservations = $repo->findAll();

        return $this->render('pages/reservations/list.html.twig', [
            'reservations' => $reservations
        ]);
    }
}

