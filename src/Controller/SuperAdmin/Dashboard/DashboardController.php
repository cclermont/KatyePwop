<?php

namespace App\Controller\SuperAdmin\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User\User;
use App\Service\User\UserManager;
use App\Service\Message\MessageManager;
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
    private $messageManager;
    private $locationManager;
    private $institutionManager;

    public function __construct(UserManager $userManager, 
                                MessageManager $messageManager, 
                                LocationManager $locationManager, 
                                InstitutionManager $institutionManager)
    {
        $this->userManager = $userManager;
        $this->messageManager = $messageManager;
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
            "message_count" => $this->messageManager->count(),
            "location_count" => $this->locationManager->count(),
            "institution_count" => $this->institutionManager->count(),
            "message_graph" => $this->convertGraphArrayKeys($this->messageManager->findAllGraph($this->getDatePattern())),

            "user_role_count" => [
                $this->userManager->countByRole(User::ROLE_SUPER_ADMIN),
                $this->userManager->countByRole(User::ROLE_ADMIN),
                $this->userManager->countByRole(User::ROLE_OPERATOR),
                // $this->userManager->countByRole(User::ROLE_ROAD_AGENT),
                $this->userManager->countByRole(User::ROLE_USER_SIMPLE),
            ],

        ]);
    }

    private function getDatePattern()
    {
        $to = new \DateTime();
        $from = (new \DateTime())->sub(new \DateInterval('P1Y'));

        return ['date_from' => $from->format('Y-m-d'), 'date_to' => $to->format('Y-m-d')];
    }

    public function convertGraphArrayKeys(array $items): array
    {
        $response = [];

        foreach ($items as $item) {
            $elem = [];
            foreach ($item as $key => $value) {
                if ($key == 'stat_date') {
                    $elem['date'] = $value;
                } else if ($key == 'stat_count') {
                    $elem['count'] = $value;
                }
            }
            $response[] = $elem;
        }

        return $response;
    }
}
