<?php

namespace App\Controller\Frontend\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/frontend/user/security", name="frontend_user_security")
     */
    public function index()
    {
        return $this->render('frontend/user/security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
}
