<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Service\TripManager;
use App\Repository\TripRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TripController extends AbstractController
{
    /**
     * @Route("/api/trips", name="app_trips", methods={"GET"} )
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
      *
      * @Route("/api/trips/random", name="api_trips_get_item_random", methods={"GET"})
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

    /**
     * @Route("/api/trip/add", name="api_trips_post", methods={"POST"})
     */
    public function createItem(Request $request, SerializerInterface $serializer, ManagerRegistry $managerRegistry, TripManager $tripManager)
    {

    $jsonContent = $request->getContent();
    $user = $this->getUser();

    $trip = $serializer->deserialize($jsonContent, Trip::class, 'json');

    $trip = $tripManager->createTrip($trip, $user);

    return $this->json(
        $trip,
        201,
        [],
        ['groups' => 'get_collection']
    );
    }

 
    

    /**
     *
     * @Route("/api/trip/{id}", name="api_trip_put", methods={"PUT"})
     */
    public function editItem(Request $request, Trip $trip = null, SerializerInterface $serializer, TripRepository $tripRepository)
    {

        if ($trip == null) {
            return $this->json(
                'Erreur => Voyage non trouvé',
                400,
                [''],
                ['groups' => '']
            );
        }

        $jsonContent = $request->getContent();

        $serializer->deserialize($jsonContent, Trip::class, 'json', ['object_to_populate' => $trip]);
        $tripRepository->add($trip, true);
        return $this->json(
            $trip,
            200,
            [''],
            ['groups' => 'get_collection']
        );
    }

    /**
     *
     * @Route("/api/trip/{id}", name="api_movies_put", methods={"DELETE"})
     */

    public function deleteItem(Trip $trip, EntityManagerInterface $em, $id): JsonResponse
    {
        
        $em->remove($trip);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }


    private $TripManager;

    public function __construct(TripManager $TripManager)
    {

        $this->TripManager = $TripManager;
    }
    
    /**
    * @Route("/api/users/", name="api_get_user_trips", methods ={"GET"})
    */
    public function showTripsUser(TripManager $tripManager): Response
    {

        $user = $this->getUser();

            $trips = $tripManager -> getTripsForUser($user);

            return $this->json(
                ['trips' => $trips],
                200,
                [''],
                ['groups' => 'get_collection']
            );   
    }
}

