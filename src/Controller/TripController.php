<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Repository\TripRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
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
      * Retourne un voyage au hasard
      * @Route("/api/trips/random", name="api_movies_get_item_random", methods={"GET"})
      */

    public function getItemRandom(TripRepository $tripRepository)
    {

        $randomTrip = $tripRepository->findOneRandomTrip();

        return $this->json(
            $randomTrip,
            200,
            [],
            ['groups' => 'get_collection']
        );
        
    }

     /**
     * Route qui va nous permettre de rajouter un film à l'aide d'une requête HTTP en methode POST
     * 
     * @Route("/api/create/trip", name="api_trip_post", methods={"POST"})
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
        // Et la on a envoyé $movie (qui de base est ce qu'on a intercepté de l'api)

        //On retourne la réponse adapté (le code attendu quand un post a bien fonctionné c'est le code 201)
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
     * @Route("/api/trip/{id}", name="api_trip_delete", methods={"DELETE"})
     */

     public function deleteItem(Trip $trip, EntityManagerInterface $em): JsonResponse
     {
         $em->remove($trip);
         $em->flush();
 
         return new JsonResponse(null, Response::HTTP_NO_CONTENT);
     }
}
