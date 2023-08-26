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
      * @Route("/back/user", name="app_back_user", methods={"GET"})
      */
    public function home(UserRepository $userRepository):Response
     {
        return $this->render('back/home.html.twig', 
        ['users' => $userRepository->findAll(),]);
     }

      /**
      * @Route("back/user/{id}", name="app_back_user_show", methods={"GET"})
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
      * @Route("/back/user/delete/{id<\d+>}", name="app_post_delete")
      */
     public function delete(UserRepository $userRepository, $id, ManagerRegistry $doctrine)
     {
        
         $user = $userRepository->find($id);

         
         $entityManager = $doctrine->getManager();
        
         $entityManager->remove($user);
        var_dump($user);
         $entityManager->flush();
         return $this->redirectToRoute('app_back_user');
     }
 }

