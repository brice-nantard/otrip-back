<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Repository\TripRepository;
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
     * Route qui va nous permettre de modifier un voyage 
     * 
     * @Route("/api/trip/{id}/edit", name="api_trip_put", methods={"PUT"})
     */
    public function editItem(Request $request, Trip $trip = null, SerializerInterface $serializer, TripRepository $tripRepository)
    {
        if ($trip == null) {
            return $this->json(
                'Error',
                400,
                [''],
                ['groups' => '']
            );
        }
        // Ici on stock le json envoyé dans la requête dans $jsonContent
        $jsonContent = $request->getContent();
        // Ici je déserialise le json intercepté ($jsonContent) et je modfie mon entité $movie avec ce json deserialisé grace a l'option object to populate
        // ['object_to_populate' => $movie] me permet de dire que je veux que $movie (le film courant que je veux modifier) aura les valeurs qui ont été renseignées dans la requêtte HTTP (le title, duréer, etc)
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
     * Route qui va nous permettre de supprimer un voyage
     * 
     * @Route("/api/trip/{id}", name="api_movies_put", methods={"DELETE"})
     */
    public function deleteItem(TripRepository $tripRepository, Trip $trip = null)
    {
        // Si le voyage qu'on veut supprimer n'existe pas
        if ($trip === null) {
            return $this->json(
                'Erreur => Film non trouvé',
                400,
                [''],
                ['groups' => '']
            );
        }
        // Ci dessous je supprime le voyage
        $tripRepository->remove($trip, true);
        return $this->json(
            $trip,
            400,
            [''],
            ['groups' => 'get_collection']
        );
    }
}
