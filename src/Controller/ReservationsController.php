<?php

namespace App\Controller;

use App\Entity\Availability;
use App\Entity\Reservations;
use App\Entity\User;
use App\Form\ReservationsType;
use App\Repository\ReservationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

class ReservationsController extends AbstractController
{
    #[Route('/reservations/new', name: 'app_reservations')]
    public function index(Request $resquest, EntityManagerInterface $em, ReservationsRepository $repo): Response
    {
        $reservations = new Reservations();
        $form = $this->createForm(ReservationsType::class, $reservations);
        $form->handleRequest($resquest);
        if ($form->isSubmitted() && $form->isValid()) {

            $reservation = $form->getData();
            // Inviter le client a choisir un autre jour si la limite de nombre de convive a été atteint
            if($reservation->getAvailability()->getGuestMax() <= 0){
                $this->addFlash('error', 'Le restaurant est complet aujourdhui, merci de choisir un autre jour');
                return $this->redirectToRoute('app_reservations');
            }
            
            $nbPerson = $reservation->getNbPerson();
            
            // Inviter le client a choisir un autre jour si le nombre de convive max autorisé est inférieur au nombre de personne dans la reservation ⁄
            if($reservation->getAvailability()->getGuestMax() < $nbPerson){
                $this->addFlash('error', 'Il n\'y a plus assez de place pour aujourdhui, merci de choisir un autre jour');
                return $this->redirectToRoute('app_reservations');
            }

            if($this->getUser()){
                $reservation->setUser($this->getUser());
            }


            // Récuperer la valeur de guestMax
            $currentValue = $reservation->getAvailability()->getGuestMax();
            // Décrementer le nombre après la soumission d'une reservation
            $reservation->getAvailability()->setGuestMax($currentValue - $nbPerson);

            // On récupérer dans un tableau la liste des dates et des slots qui ont déja été pris dans les reservations
            $resa = $repo->findAll();

            // On construit un tableau pour avoir les slots choisis par date 
            $slotArrayPerDate = [];
            for ($i = 0; $i < count($resa); $i++) {
                $slotArrayPerDate[$i]['date'] = $resa[$i]->getReservationDate();
                $slotArrayPerDate[$i]['slot'] = $resa[$i]->getSlot();
            }

            // On verifie dans le tableaux si le slot à une date données choisi par le client a déja été pris dans les reservations
            for ($i = 0; $i < count($slotArrayPerDate); $i++) {
                if ($reservation->getSlot() == $slotArrayPerDate[$i]['slot'] && $reservation->getReservationDate() == $slotArrayPerDate[$i]['date']) {
                    $this->addFlash('error', 'Le créneau n\'est plus disponible');
                    return $this->redirectToRoute('app_reservations');
                } else {
                    // $this->addFlash('success', 'Votre réservation a été prise en compte');
                }
            }

            $em->persist($reservation);
            $em->flush();
            return $this->redirectToRoute('app_reservations');
        }

        return $this->render('pages/reservations/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reservations/list', name: 'app_reservations_list')]
    public function list(ReservationsRepository $repo): Response
    {
        $reservations = $repo->findAll();

        return $this->render('pages/reservations/list.html.twig', [
            'reservations' => $reservations
        ]);
    }
}
