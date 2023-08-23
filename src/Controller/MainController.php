<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * Homepage
     * 
     * @Route("/", name="app_main_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {    
        return $this->render('main/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
}

