<?php

namespace App\Controller;

use App\Entity\Step;
use App\Entity\Trip;
use App\Repository\StepRepository;
use App\Repository\TripRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class StepController extends AbstractController
{
    /**
     * @Route("/api/trips/{id}/steps", name="app_trips_steps", methods={"GET"} )
     */
    public function getStepList(StepRepository $stepRepository): JsonResponse
    {
        $stepList = $stepRepository->findStepsFromTrip();

        return $this->json(
            $stepList,
            200,
            [],
            ['groups' => 'get_collection']
        );
    }

    /**
     * @Route("/api/steps/trips/{id})
     */
    //public function getStepsFromTrip(StepRepository $stepRepository): JsonResponse
    //{
    //    $tripSteps = $stepRepository->findStepsFromTrip();

    //    return $this->json(
    //        $tripSteps,
    //        200,
    //        [],
    //        ['groups' => 'get_collection']
    //    );
    //}

    /**
     * Route qui va nous permettre de rajouter un film à l'aide d'une requête HTTP en methode POST
     * 
     * @Route("/api/create/step", name="api_step_post", methods={"POST"})
     */
    public function createItem(Request $request, SerializerInterface $serializer, ManagerRegistry $managerRegistry)
    {
        // Ici on récupère le contenu JSON de la requête
        $jsonContent = $request->getContent();

        // Ici on déserialise (convertit) le JSON intercépté en objet PHP donc => en entité Movie
        $step = $serializer->deserialize($jsonContent, Step::class, 'json');
        // Maintenant $movie c'est une entité Movie et on va la sauvegarder dans la bdd
        $entityManager = $managerRegistry->getManager();
        $entityManager->persist($step);
        $entityManager->flush();
        // Et la on a envoyé $movie (qui de base est ce qu'on a intercepté de l'api)

        //On retourne la réponse adapté (le code attendu quand un post a bien fonctionné c'est le code 201)
        return $this->json(
            $step,
            201,
            [],
            ['groups' => 'get_collection']
        );
    }


}



