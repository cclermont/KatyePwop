<?php

namespace App\Controller\Admin\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User\User;
use App\Service\User\UserManager;
use App\Service\Message\MessageManager;
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
    private $institutionManager;

    public function __construct(UserManager $userManager, 
                                MessageManager $messageManager, 
                                InstitutionManager $institutionManager)
    {
        $this->userManager = $userManager;
        $this->messageManager = $messageManager;
        $this->institutionManager = $institutionManager;
    }

    /**
     * @Route("/", name="admin_dashboard")
     * @Route("/dashboard", name="admin_dashboard")
     */
    public function index()
    {
        // Get institution
        $institution = $this->institutionManager->findByUser($this->getUser());

        return $this->render('admin/dashboard/index.html.twig', [
            
            "user_admin_count" => $institution->getAdministrators()->count(),
            "user_operator_count" => $institution->getOperators()->count(),
            "user_road_agent_count" => $institution->getRoadAgents()->count(),
            "message_sent_count" => $this->messageManager->countSentByInstitution($institution),
            "message_received_count" => $this->messageManager->countReceivedByInstitution($institution),
            "message_received_graph" => $this->convertGraphArrayKeys($this->messageManager->findReceivedGraph($institution, $this->getDatePattern())),

            "user_role_count" => [
                $institution->getAdministrators()->count(),
                $institution->getOperators()->count(),
                $institution->getRoadAgents()->count(),
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
