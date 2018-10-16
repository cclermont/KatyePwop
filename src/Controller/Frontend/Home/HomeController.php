<?php

namespace App\Controller\Frontend\Home;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="frontend_home_home")
     * @Route("/{_locale<%app_locales%>?%locale%}", name="frontend_home_home_2")
     */
    public function index()
    {
        return $this->render('frontend/home/home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
