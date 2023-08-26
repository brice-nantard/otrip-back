<?php


 namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\Routing\Annotation\Route;
 use App\Repository\UserRepository;

 class UserController extends AbstractController
 {
     /**
      * Homepage
      * 
      * @Route("/back/users", name="app_back_users", methods={"GET"})
      */
    public function list(UserRepository $userRepository):Response
     {
        return $this->render('back/home.html.twig', 
        ['users' => $userRepository->findAll(),]);
     }

      /**
      * @Route("/back/users/{id<\d+>}", name="app_back_users_show", methods={"GET"})
      */
      public function show(User $user): Response
      {
          return $this->render('back/show.html.twig', [
              'user' => $user,
          ]);
      }

      /**
      * Delete
      * 
      * @Route("/back/users/delete/{id<\d+>}", name="app_users_delete")
      */
     public function delete(UserRepository $userRepository, $id, ManagerRegistry $doctrine)
     {
        
         $user = $userRepository->find($id);

         $entityManager = $doctrine->getManager();
        
         $entityManager->remove($user);
         $entityManager->flush();
         return $this->redirectToRoute('app_back_users');
     }
 }

