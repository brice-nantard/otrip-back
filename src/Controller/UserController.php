<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * Homepage
     * 
     * @Route("/back/users", name="app_back_user", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {    
        return $this->render('back/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

     /**
      * @Route("back/user/{id}", name="app_back_user_show", methods={"GET"})
      */
      public function show(UserRepository $userRepository, $id): Response
      {
          return $this->render('back/show.html.twig', [
              'user' => $userRepository->find($id),
          ]);
      }

      /**
      * Delete
      * 
      * @Route("/back/user/{id<\d+>}", name="app_post_delete")
      */
     public function delete(UserRepository $userRepository, $id, ManagerRegistry $doctrine)
     {
        
         $user = $userRepository->find($id);

         
         $entityManager = $doctrine->getManager();
        
         $entityManager->remove($user);
        var_dump($user);
         $entityManager->flush();
         return $this->redirectToRoute('app_back_users');
     }
}
