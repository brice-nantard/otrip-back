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

