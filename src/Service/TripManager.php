<?php

namespace App\Service;

use App\Entity\Trip;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;



class TripManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getTripsForUser(User $user)
    {
        $tripRepository = $this->entityManager->getRepository(Trip::class);

        $trips = $tripRepository->findBy(['user' => $user]);

        return $trips;
    }

    public function createTrip(Trip $trip, User $user)
    {
        $trip->setCreatedAt(new DateTimeImmutable());
        $trip->setUser($user);
        $this->entityManager->persist($trip);
        $this->entityManager->flush();

        return $trip;
    }

    public function getById(int $id)
    {
        $tripRepository = $this->entityManager->getRepository(Trip::class);

        $trip = $tripRepository->find($id);

        return $trip;
    }
}
    