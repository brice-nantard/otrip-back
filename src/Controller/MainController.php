<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * Homepage
     * 
     * @Route("/", name="app_main_home", methods={"GET"})
     */
    public function home()
    {    
        return $this->render('main/home.html.twig', []);
    }
}

