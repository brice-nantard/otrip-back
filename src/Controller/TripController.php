<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Form\TripType;
use App\Repository\TripRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormTypeInterface;

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
     * 
     * 
     * @Route("/api/trips/add", name="api_trips_post", methods={"POST"})
     */
    public function createItem(Request $request, SerializerInterface $serializer, ManagerRegistry $managerRegistry)
    {
        // Ici on récupère le contenu JSON de la requête
        $jsonContent = $request->getContent();

        // Ici on déserialise (convertit) le JSON intercépté en objet PHP donc => en entité Movie
        $trip = $serializer->deserialize($jsonContent, Trip::class, 'json');
        // Maintenant $movie c'est une entité Movie et on va la sauvegarder dans la bdd
        $entityManager = $managerRegistry->getManager();
        $entityManager->persist($trip);
        $entityManager->flush();
     

        //On retourne la réponse adapté (le code attendu quand un post a bien fonctionné c'est le code 201)
        return $this->json(
            $trip,
            201,
            [],
            ['groups' => 'get_collection']
        );
    }

}