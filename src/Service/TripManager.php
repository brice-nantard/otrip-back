<?php

namespace App\Service;
use App\Entity\Trip;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class TripsManager
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

}