<?php

namespace App\Service;


use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function createUser( User $user, UserPasswordHasherInterface $passwordHasher)
    {
        $user->setCreatedAt(new DateTimeImmutable());
        $user->setRoles(['ROLE_USER']);
        $plainTextPassword = $user->getPassword();
        $hashedPassword = $passwordHasher->hashPassword($user, $plainTextPassword);
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}