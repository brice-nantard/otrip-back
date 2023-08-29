<?php


 namespace App\Controller;

 use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
 use App\Form\UserType;
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
      * @Route("/back/users/create", name="app_back_users_create", methods={"GET", "POST"})
      */
     public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher ): Response
     {
         $user = new User();
         $form = $this->createForm(UserType::class, $user);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {

            $plainTextPassword = $user->getPassword();
            $hashedPassword = $passwordHasher->hashPassword($user, $plainTextPassword);
            $user->setPassword($hashedPassword);
             $userRepository->add($user, true);

             return $this->redirectToRoute('app_back_users', [], Response::HTTP_SEE_OTHER);
         }

         return $this->renderForm('back/new.html.twig', [
             'user' => $user,
             'form' => $form,
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

