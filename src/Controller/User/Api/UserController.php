<?php

namespace App\Controller\User\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/api/user", name="user_api_user")
     */
    public function index()
    {
        return $this->render('user/api/user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
