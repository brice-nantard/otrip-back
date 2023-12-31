<?php

namespace App\Service;

use DateTime;
use App\Entity\Step;
use App\Entity\Trip;
use DateTimeImmutable;
use App\Entity\Transport;
use App\Entity\Accomodation;
use App\Repository\StepRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class StepManager
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

    public function createStep(Step $step)
    {
        $trip = $step->getTrip();
        $accomodation = $step->getAccomodation();
        $transport = $step->getTransport();

        $step->setCreatedAt(new DateTimeImmutable());
        //$step->setTrip($trip);
        $this->entityManager->persist($step);
        $this->entityManager->flush();

        return $step;
    }

    public function getById(int $id)
    {
        $stepRepository = $this->entityManager->getRepository(Step::class);

        $step = $stepRepository->find($id);

        return $step;
    }

    

    
}