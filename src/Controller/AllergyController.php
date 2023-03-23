<?php

namespace App\Controller;

use App\Entity\Allergy;
use App\Form\AllergyType;
use App\Entity\Reservations;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AllergyController extends AbstractController
{
    // Seul un utilisateur connecté pourra ajouter une allergie    
    #[Security("is_granted('ROLE_USER')")]
    #[Route('/allergy/new', name: 'app_allergy_new')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {

        // Formulaire rajout d'une ALLERGIE
        $currentUser = $this->getUser();
        $allergy = new Allergy();

        $form = $this->createForm(AllergyType::class, $allergy);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $allergy = $form->getData();
            if ($currentUser) {
                $allergy->setOwner($currentUser);
            }
            $em->persist($allergy);
            $em->flush();

            return $this->redirectToRoute('app_user_profile',['slug'=> $this->getUser()->getSlug()]);

            // $roles = $this->getUser()->getRoles();

            // if (in_array("ROLE_ADMIN", $roles)) {
            //     return $this->redirectToRoute('app_reservations_list');
            // } elseif (in_array("ROLE_USER", $roles)) {
            // } else {
            //     return $this->redirectToRoute('app_home');
            // }
        }

        return $this->render('pages/allergy/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
