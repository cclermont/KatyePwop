<?php

namespace App\Controller\SuperAdmin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="super_admin_dashboard")
     * @Route("/dashboard", name="super_admin_dashboard")
     */
    public function index()
    {
        return $this->render('super_admin/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
