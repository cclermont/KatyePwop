<?php

namespace App\Controller\Api\User;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Service\User\UserManager;
use App\Controller\Api\ControllerResponseDataTrait;

/**
 * ProfileController 
 *
 * @Route("/user/profile")
 */ 
class ProfileController extends FOSRestController
{
    /**
    * Entity manager
    */
    private $em;

    public function __construct(UserManager $entityManager)
    {
        $this->em = $entityManager;
    }

    // Response data trait
    use ControllerResponseDataTrait;

    /**
     * Single get
     * @Security("has_role('ROLE_USER_SIMPLE')")
     * @Route("/", name="api_user_profile_show", defaults={"_format": "json"}, methods={"GET"})
     */
    public function sget(Request $request)
    {
        // Find entity by id
        $entity = $this->getUser();
        
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
     * @Security("has_role('ROLE_USER_SIMPLE')")
     * @Route("/", name="api_user_profile_edit", defaults={"_format": "json"}, methods={"PUT"})
     */
    public function edit(Request $request)
    {
        // Create entity
        $entity = $this->getUser()->getProfile();

        // Create form
        $form = $this->createForm($this->em->getFormType(), $entity, ['context' => MessageType::API_CONTEXT]);

        // Handle request
        $form->handleRequest($request);

        // Get response data
        $resData = $this->getResponseData();
        
        // If submitted and valided
        if ($form->isSubmitted() && $form->isValid())
        {
            // Create entity
            $this->em->update($entity);

            // Return view
            return $this->view($resData, Response::HTTP_NO_CONTENT);
        }

        // Add form to response data
        $resData->set('form', $form);
        $resData->set('error', true);

        // Return view
        return $this->view($resData, Response::HTTP_BAD_REQUEST);
    }
}
