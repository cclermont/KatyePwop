<?php

namespace App\Controller\Api\Message;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Entity\Message\Schedule;
use App\Service\Message\ScheduleManager;
use App\Service\Location\LocationManager;
use App\Controller\Api\ControllerResponseDataTrait;

/**
 * ScheduleController 
 *
 * @Route("/schedule")
 */ 
class ScheduleController extends FOSRestController
{
    /**
    * Entity manager
    */
    private $em;
    private $locationManager;

    public function __construct(ScheduleManager $entityManager, LocationManager $locationManager)
    {
        $this->em = $entityManager;
        $this->locationManager = $locationManager;
    }

    // Response data trait
    use ControllerResponseDataTrait;

    /**
     * Collection get
     * @Security("has_role('ROLE_USER_SIMPLE')")
     * @Route("/{id<\d+>}", name="api_message_schedule", defaults={"_format": "json"}, methods={"GET"})
     */
    public function cget(Request $request, $id): View
    {
        // Find entity by id
        $location = $this->locationManager->find($id);
        
        // Test if entity was found
        if (!$location) {
            throw $this->createNotFoundException("No location found for id($id)");
        }
        
        $entities = $this->em->findByLocation($location);
        
        // Get response data
        $resData = $this->getResponseData();

        // Set total
        $resData->set('total', $entities->getNbResults());

        // Add form to response data
        $resData->set('data', $entities->getCurrentPageResults()->getArrayCopy());

        // Set serialization context
        $context = (new Context())->addGroup('list');

        //Create view
        $view = $this->view($resData, Response::HTTP_OK);
        
        // Render view
        return $view->setContext($context);
    }
}
