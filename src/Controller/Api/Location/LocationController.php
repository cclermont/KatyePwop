<?php

namespace App\Controller\Api\Location;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Entity\Location\Location;
use App\Service\Location\LocationManager;
use App\Controller\Api\ControllerResponseDataTrait;

/**
 * LocationController 
 *
 * @Route("/location")
 */ 
class LocationController extends FOSRestController
{
    /**
    * Entity manager
    */
    private $em;

    public function __construct(LocationManager $entityManager)
    {
        $this->em = $entityManager;
    }

    // Response data trait
    use ControllerResponseDataTrait;

    /**
     * @Route("/", name="api_location", defaults={"_format": "json"}, methods={"GET"})
     */
    public function cget(Request $request): View
    {
        // Sort and pattern
        $page     = $request->query->get('page', 1);
        $limit    = $request->query->get('limit', 50);
        $pattern  = $request->query->get('pattern', array());
        $sort     = $request->query->get('sort', array('created' => 'DESC'));

        // Get entities
        $entities = $this->em->findAndPaginate($pattern, $sort, $page, $limit);
        
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
