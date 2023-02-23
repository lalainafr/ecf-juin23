<?php

namespace App\Controller;

use App\Repository\AvailabilityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvailabilityController extends AbstractController
{
    #[Route('/availability/{id}', name: 'app_availability')]
    public function index(AvailabilityRepository $repo, $id): JsonResponse
    {
        $availabilities = $repo->findById($id);
        $data =  [];
        foreach ($availabilities as $key => $value) {
            $data[$key]['date'] = $value->getDate();
            $data[$key]['guestMax'] = $value->getGuestMax();
            
        }
        return new JsonResponse($data);
    }    
}