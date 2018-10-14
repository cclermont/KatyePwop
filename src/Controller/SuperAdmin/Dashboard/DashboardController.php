<?php

namespace App\Controller\SuperAdmin\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\User\UserManager;
use App\Service\Location\LocationManager;

/**
 * DashboardController 
 *
 */ 
class DashboardController extends AbstractController
{
    /**
    * Entity managers
    */
    private $userManager;
    private $locationManager;

    public function __construct(UserManager $userManager, LocationManager $locationManager)
    {
        $this->userManager = $userManager;
        $this->locationManager = $locationManager;
    }

    /**
     * @Route("/", name="super_admin_dashboard")
     * @Route("/dashboard", name="super_admin_dashboard")
     */
    public function index()
    {
        return $this->render('super_admin/dashboard/index.html.twig', [
            "user_count" => $this->userManager->count(),
            "location_count" => $this->locationManager->count(),
        ]);
    }
}
