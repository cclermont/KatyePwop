<?php

namespace App\Controller\SuperAdmin\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User\User;
use App\Service\User\UserManager;
use App\Service\Location\LocationManager;
use App\Service\Institution\InstitutionManager;

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
    private $institutionManager;

    public function __construct(UserManager $userManager, 
                                LocationManager $locationManager, 
                                InstitutionManager $institutionManager)
    {
        $this->userManager = $userManager;
        $this->locationManager = $locationManager;
        $this->institutionManager = $institutionManager;
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
            "institution_count" => $this->institutionManager->count(),
            "user_role_count" => [
                $this->userManager->countByRole(User::ROLE_SUPER_ADMIN),
                $this->userManager->countByRole(User::ROLE_ADMIN),
                $this->userManager->countByRole(User::ROLE_OPERATOR),
                // $this->userManager->countByRole(User::ROLE_ROAD_AGENT),
                $this->userManager->countByRole(User::ROLE_USER),
            ],

        ]);
    }
}
