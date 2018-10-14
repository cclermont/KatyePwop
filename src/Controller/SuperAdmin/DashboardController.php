<?php

namespace App\Controller\SuperAdmin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\Location\LocationManager;

class DashboardController extends AbstractController
{
    /**
    * Entity managers
    */
    private $locationEm;

    public function __construct(LocationManager $locationEm)
    {
        $this->locationEm = $locationEm;
    }

    /**
     * @Route("/", name="super_admin_dashboard")
     * @Route("/dashboard", name="super_admin_dashboard")
     */
    public function index()
    {
        return $this->render('super_admin/dashboard/index.html.twig', [
            "location_count" => $this->locationEm->count(),
        ]);
    }
}
