<?php

namespace App\Controller\Api\Institution;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Entity\Institution\Institution;
use App\Service\Location\LocationManager;
use App\Service\Institution\InstitutionManager;
use App\Controller\Api\ControllerResponseDataTrait;

/**
 * InstitutionController 
 *
 * @Route("/institution")
 */ 
class InstitutionController extends FOSRestController
{
    /**
    * Entity manager
    */
    private $em;
    private $locationManager;

    public function __construct(InstitutionManager $entityManager, LocationManager $locationManager)
    {
        $this->em = $entityManager;
        $this->locationManager = $locationManager;
    }

    // Response data trait
    use ControllerResponseDataTrait;

    /**
     * @Route("/", name="api_institution_institution", defaults={"_format": "json"}, methods={"GET"})
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

    /**
     * Single get
     * @Security("has_role('ROLE_USER_SIMPLE')")
     * @Route("/{id<\d+>}", name="api_institution_institution_show", defaults={"_format": "json"}, methods={"GET"})
     */
    public function sget(Request $request, $id)
    {
        // Find entity by id
        $entity = $this->em->find($id);
        
        // Test if entity was found
        if (!$entity) {
            throw $this->createNotFoundException("No entity found for id($id)");
        }

        // Get response data
        $resData = $this->getResponseData();

        // Add form to response data
        $resData->set('total', 1);
        $resData->set('data', $entity);

        // Set serialization context
        $context = (new Context())->addGroup('show');

        //Create view
        $view = $this->view($resData, Response::HTTP_OK);
        
        // Render view
        return $view->setContext($context);
    }

    /**
     * Single get
     * @Security("has_role('ROLE_USER_SIMPLE')")
     * @Route("/location/{id<\d+>}", name="api_institution_institution_show_by_location", defaults={"_format": "json"}, methods={"GET"})
     */
    public function sgetByLocation(Request $request, $id)
    {
        // Find entity by id
        $location = $this->locationManager->find($id);
        
        // Test if entity was found
        if (!$location) {
            throw $this->createNotFoundException("No location found for id($id)");
        }
        
        $entity = $this->em->findByLocation($location);
        
        // Test if entity was found
        if (!$entity) {
            throw $this->createNotFoundException("No entity found for id($id)");
        }

        // Get response data
        $resData = $this->getResponseData();

        // Add form to response data
        $resData->set('total', 1);
        $resData->set('data', $entity);

        // Set serialization context
        $context = (new Context())->addGroup('show');

        //Create view
        $view = $this->view($resData, Response::HTTP_OK);
        
        // Render view
        return $view->setContext($context);
    }
}
