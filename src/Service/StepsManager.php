<?php

namespace App\Service;

use DateTime;
use App\Entity\Step;
use App\Entity\Trip;
use App\Repository\StepRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class StepsManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getStepsForTrip(Trip $trip)
    {
        $stepRepository = $this->entityManager->getRepository(Step::class);
        
        $steps = $stepRepository->findBy(['trip' => $trip]);

        return $steps;
    }

    public function createStep(Step $step, Trip $trip)
    {
        $step->setCreatedAt(new DateTimeImmutable());
        $step->setTrip($trip);
        $this->entityManager->persist($step);
        $this->entityManager->flush();

        return $step;
    }

    
}