<?php

namespace App\Controller\Frontend\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="frontend_home_home")
     */
    public function index()
    {
        return $this->render('frontend/home/home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
