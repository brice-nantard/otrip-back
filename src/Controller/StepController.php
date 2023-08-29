<?php

namespace App\Controller;

use App\Entity\Step;
use App\Entity\Trip;
use App\Repository\StepRepository;
use App\Repository\TripRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;


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
}



