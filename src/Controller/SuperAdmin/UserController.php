<?php

namespace App\Controller\SuperAdmin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/super/admin/user", name="super_admin_user")
     */
    public function index()
    {
        return $this->render('super_admin/user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
