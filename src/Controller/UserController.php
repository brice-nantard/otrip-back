<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Entity\User;
use App\Service\UserManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController

{
 /** 
  * @Route("/api/login/create", name="api_login_new", methods={"POST"} )
  */

  public function new (Request $request, SerializerInterface $serializer, ManagerRegistry $managerRegistry, UserManager $userManager, UserPasswordHasherInterface $passwordHasher)
  {
     $user = new User();
    $jsonContent = $request->getContent();
  
    $user = $serializer->deserialize($jsonContent, User::class, 'json');

    $user = $userManager->createUser($user, $passwordHasher);

    return $this->json(
        $user,
        201,
        [],
        ['groups' => 'get_collection']
    );

  }
    

}