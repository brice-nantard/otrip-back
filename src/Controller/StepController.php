<?php

namespace App\Controller;

use App\Entity\Step;
use App\Entity\Trip;
use App\Service\StepsManager;
use App\Repository\StepRepository;
use App\Repository\TripRepository;
use App\Service\TripsManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


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
     * Route qui va nous permettre de rajouter un film à l'aide d'une requête HTTP en methode POST
     * 
     * @Route("/api/trip/{id}/step/add", name="api_step_post", methods={"POST"})
     */
    public function createItem(Request $request, SerializerInterface $serializer, ManagerRegistry $managerRegistry, TripsManager $tripsManager, StepsManager $stepsManager, int $id, Trip $trip)
    {
        $jsonContent = $request->getContent();

        $trip = $tripsManager->getById($id);      
        
        $step = $serializer->deserialize($jsonContent, Step::class, 'json');

        $step = $stepsManager->createStep($step, $trip);
        
        return $this->json(
            ['step' => $step],
            201,
            [],
            ['groups' => 'get_collection']
        );
    }



    private $stepsManager;

    public function __construct(StepsManager $stepsManager)
    {

        $this->stepsManager = $stepsManager;
    }

    /**
    * @Route("/api/trip/{id}/steps", name="api_get_trip_steps", methods ={"GET"})
    */
    public function showStepsTrip(StepsManager $stepsManager, TripsManager $tripsManager, $id): Response
    {

        //$trips = $tripsManager -> getTripsForUser($user);
        $trip = $tripsManager->getById($id);

            $steps = $stepsManager->getStepsForTrip($trip);

            return $this->json(
                ['steps' => $steps],
                200,
                [''],
                ['groups' => 'get_collection']
            );
       
    }
}



