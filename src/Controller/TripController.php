<?php

namespace App\Controller;

use App\Repository\TripRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TripController extends AbstractController
{
    /**
     * @Route("/api/trips", name="app_trip", methods={"GET"} )
     */
    public function getTripsList(TripRepository $tripRepository): JsonResponse
    {
        $tripList = $tripRepository->findAll();

        return $this->json(
            $tripList,
            200,
            [],
            ['groups' => 'get_collection']
        );
    }


    /**
      * Retourne un film au hasard
      * @Route("/api/trips/random", name="api_movies_get_item_random", methods={"GET"})
      */

    public function getItemRandom(TripRepository $tripRepository)
    {

        $randomTrip = $tripRepository->findOneRandomTrip();

        return $this->json(
            $randomTrip,
            200,
            [],
            ['groups' => '']
        );
    }

}