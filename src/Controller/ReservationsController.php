<?php

namespace App\Controller;

use DateTime;
use DateInterval;
use App\Entity\User;
use App\Entity\Availability;
use App\Entity\Reservations;
use App\Form\ReservationsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AvailabilityRepository;
use App\Repository\ReservationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationsController extends AbstractController
{
    #[Route('/reservations/new', name: 'app_reservations_new')]
    public function index(Request $resquest, EntityManagerInterface $em, ReservationsRepository $reservationsRepository): Response
    {
        $reservations = new Reservations();

        // Si l'utilisateur est connecté, on prépopuler le formulaire avec ses informations par défaut (nom et prénom, nombre de convive, allergie)
        if ($this->getUser()) {
            $reservations->setFullName($this->getUser()->getFullName());
            $reservations->setNbPerson($this->getUser()->getNbGuest());
        }

        $form = $this->createForm(ReservationsType::class, $reservations);

        $form->handleRequest($resquest);
        if ($form->isSubmitted() && $form->isValid()) {

            $reservation = $form->getData();

            $nbPerson = $reservation->getNbPerson();

            // --- NE PAS PERMETTRE DE CHOISIR UNE DATE ANTERIEUR A LA DATE DU JOUR ---
            $dateNow = new DateTime("- 1 days");
            $newDate = $reservation->getReservationDate();

            if ($newDate < $dateNow) {
                $this->addFlash('error', 'Date antérieure à la date du jour non autorisée');
                return $this->redirectToRoute('app_reservations_new');
            }

            // --- CHOISIR UN AUTRE JOUR (Inviter le client a choisir un autre jour si le nombre de convive max autorisé est inférieur au nombre de personne dans la reservation) ---
            if ($reservation->getAvailability()->getGuestMax() < $nbPerson) {
                $this->addFlash('error', 'Il n\'y a plus assez de place pour aujourdhui, merci de choisir un autre jour');
                return $this->redirectToRoute('app_reservations_new');
            }

            if ($this->getUser()) {
                $reservation->setUser($this->getUser());
            }

            // --- MAJ DU NOMBRE DE GUESTMAX ---

            // Récuperer la valeur de guestMax
            $currentValue = $reservation->getAvailability()->getGuestMax();
            // Décrementer le nombre de guestMax après la soumission d'une reservation
            $reservation->getAvailability()->setGuestMax($currentValue - $nbPerson);

            // --- CRENEAU INDISPONIBLE (si le creneau a deja ete pris) ---

            // On récupérer dans un tableau la liste des dates et des slots qui ont déja été pris dans les reservations
            $resa = $reservationsRepository->findAll();

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
                    return $this->redirectToRoute('app_reservations_new');
                } else {
                    // $this->addFlash('success', 'Votre réservation a été prise en compte');
                }
            }

            $em->persist($reservation);
            $em->flush();
            return $this->redirectToRoute('app_reservations_new');
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

    #[Route('/reservations/edit/{id}', name: 'app_reservations_edit')]
    public function edit(ReservationsRepository $reservationsRepository, $id, Request $request, EntityManagerInterface $em, AvailabilityRepository $availabilityRepository): Response
    {
        $reservation = $reservationsRepository->findOneBy(["id" => $id]);
        // On récupére les informations sur la reservation initiale à changer (avant soumission du formulaire)
        $oldId = $reservation->getAvailability()->getId();
        $oldGuestMax = $reservation->getAvailability()->getGuestMax();
        $oldDate = $reservation->getAvailability()->getDate();
        $oldAvailability = $availabilityRepository->findOneBy(["id" => $oldId]);
        $oldNbPerson = ($oldAvailability->getGuestMax());
        $oldSlot = $reservation->getSlot();

        // --- Données utiles pour la gestion des CRENEAUX INDISPONIBLES
        // On récupére dans un tableau la liste des dates et des slots qui ont déja été résérvés
        $resa1 = $reservationsRepository->findAll();
        // On construit un tableau pour avoir les slots qui ont été réservés par date et le nombre de personnes 
        $slotArrayPerDate1 = [];
        for ($i = 0; $i < count($resa1); $i++) {
            $slotArrayPerDate1[$i]['id'] = $resa1[$i]->getId();
            $slotArrayPerDate1[$i]['date'] = $resa1[$i]->getReservationDate();
            $slotArrayPerDate1[$i]['slot'] = $resa1[$i]->getSlot();
            $slotArrayPerDate1[$i]['nbPerson'] = $resa1[$i]->getNbPerson();
        }

        // TRAITEMENT DU FORMULAIRE
        $form =  $this->createForm(ReservationsType::class, $reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reservation = $form->getData();
            $newNbPerson = ($reservation->getNbPerson());
            $newGuestMax = $reservation->getAvailability()->getGuestMax();
            $newDate = $reservation->getReservationDate();
            $newSlot = $reservation->getSlot();
            $dateNow = new DateTime("- 1 days");

            // --- NE PAS PERMETTRE DE CHOISIR UNE DATE ANTERIEUR A LA DATE DU JOUR ---
            if ($newDate < $dateNow) {
                $this->addFlash('error', 'Date antérieure à la date du jour non autorisée');
                return $this->redirectToRoute('app_reservations_edit', ['id' => $reservation->getId()]);
            }

            // *** DATE DIFFERENTE ***    
            // --- CHANGEMENT DU NOMBRE DE PERSONNES  ---
            for ($i = 0; $i < count($slotArrayPerDate1); $i++) {
                // Pour avoir le nombre de personne initial: on recherche l'id de la résevation à changer qui correspond à l'id dans le tableau des réservations effectuées. A partir de l'id on récupere le nombre de personne initiale 
                if ($slotArrayPerDate1[$i]['id'] == $id) {
                    $oldNbPerson = $slotArrayPerDate1[$i]['nbPerson'];
                }
            }
            // --- MAJ DU NOMBRE DE GUESTMAX ---
            // Décrementer le nombre de guestMax de la nouvelle date choisie avec le nouveau nombre de personne de la nouvelle date après la soumission d'une reservation
            $reservation->getAvailability()->setGuestMax($newGuestMax - $newNbPerson);
            // Remettre à sa place et incrementer avec nbPerson la valeur de guestMax à la date initiale
            $oldAvailability->setGuestMax($oldGuestMax + $oldNbPerson);


            // *** MEME DATE ***
            // --- CHANGEMENT DU NOMBRE DE PERSONNES ---
            // Différence entre le nombre personnse initial et le nouveau nombre entrée par l'utilisateur
            $nbPersonDifference = $newNbPerson - $oldNbPerson;
            if ($oldDate == $newDate) {

                // --- CRENEAU INDISPONIBLE (si le creneau a deja ete pris) ---
                // On verifie dans le tableaux si le slot à une date données choisi par le client a déja été pris dans les reservations
                // N'est pas valable si les slots sont les memes
                if ($newSlot != $oldSlot)
                    for ($i = 0; $i < count($slotArrayPerDate1); $i++) {
                        if ($reservation->getSlot() == $slotArrayPerDate1[$i]['slot'] && $reservation->getReservationDate() == $slotArrayPerDate1[$i]['date']) {
                            $this->addFlash('error', 'Le créneau n\'est plus disponible');
                            return $this->redirectToRoute('app_reservations_edit', ['id' => $reservation->getId()]);
                        }
                    }

                // --- CHOISIR UN AUTRE JOUR (Inviter le client a choisir un autre jour si le nombre de convive max autorisé à la nouvelle date choisie est inférieure à la différence de nombre de personne (initiale vs nouveau) ---
                if ($oldGuestMax < $nbPersonDifference) {
                    $this->addFlash('error', 'Il n\'y a plus assez de place pour aujourdhui, merci de choisir un autre jour');
                    return $this->redirectToRoute('app_reservations_edit', ['id' => $reservation->getId()]);
                }
                // --- MAJ DU NOMBRE DE GUESTMAX ---
                // Si la date choisie pour le changement est égale à la date initiale de la reservation => le nombre de guestMax ne change pas, SINON on rajoute ou enleve la difference entre l'ancien nbPerson et le nouveau
                if ($oldNbPerson == $newNbPerson) {
                    $reservation->getAvailability()->setGuestMax($oldGuestMax);
                } elseif ($oldNbPerson > $newNbPerson) {
                    $reservation->getAvailability()->setGuestMax($oldGuestMax + abs($nbPersonDifference));
                } else {
                    $reservation->getAvailability()->setGuestMax($oldGuestMax - abs($nbPersonDifference));
                }
            }

            // *** DATE DIFFERENTE ***
            // --- CHOISIR UN AUTRE JOUR (Inviter le client a choisir un autre jour si le nombre de convive max autorisé à la nouvelle date choisie est inférieure au nombre de personne choisi pour la nouvelle date de modification) ---
            if ($oldDate != $newDate) {
                if ($newGuestMax < $newNbPerson) {
                    $this->addFlash('error', 'Il n\'y a plus assez de place pour aujourdhui, merci de choisir un autre jour');
                    return $this->redirectToRoute('app_reservations_edit', ['id' => $reservation->getId()]);
                }
            }

            // *** DATE DIFFERENTE ***
            // --- CRENEAU INDISPONIBLE (si le creneau a deja ete pris) ---
            // On verifie dans le tableaux si le slot à une date données choisi par le client a déja été pris dans les reservations
            if ($oldDate != $newDate) {
                for ($i = 0; $i < count($slotArrayPerDate1); $i++) {
                    if ($reservation->getSlot() == $slotArrayPerDate1[$i]['slot'] && $reservation->getReservationDate() == $slotArrayPerDate1[$i]['date']) {
                        $this->addFlash('error', 'Le créneau n\'est plus disponible');
                        return $this->redirectToRoute('app_reservations_edit', ['id' => $reservation->getId()]);
                    }
                }
            }

            $em->flush();

            $roles = $this->getUser()->getRoles();

            if (in_array("ROLE_ADMIN", $roles)) {
                return $this->redirectToRoute('app_reservations_list');
            } elseif (in_array("ROLE_USER", $roles)) {
                return $this->redirectToRoute('app_user_reservations',['slug'=> $this->getUser()->getSlug()]);
            } else {
                return $this->redirectToRoute('app_home');
            }
        }

        return $this->render('pages/reservations/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reservations/delete/{id}', name: 'app_reservations_delete', methods: ['GET'])]
    public function delete(ReservationsRepository $repo, EntityManagerInterface $em, Request $request, $id): Response
    {
        $reservation = $repo->findOneBy(["id" => $id]);
        $em->remove($reservation);
        $em->flush();

        $this->addFlash(
            'success',
            'La réseevation a été supprimée avec succès !'
        );

        $roles = $this->getUser()->getRoles();

        if (in_array("ROLE_ADMIN", $roles)) {
            return $this->redirectToRoute('app_reservations_list');
        } else {
            return $this->redirectToRoute('app_user_reservations');
        }
    }
}
