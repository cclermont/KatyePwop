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

use App\Entity\Message\Message;
use App\Form\Message\MessageType;
use App\Service\Message\MessageManager;
use App\Controller\Api\ControllerResponseDataTrait;

/**
 * MessageController 
 *
 * @Route("/message")
 */ 
class MessageController extends FOSRestController
{
    /**
    * Entity manager
    */
    private $em;

    public function __construct(MessageManager $entityManager)
    {
        $this->em = $entityManager;
    }

    // Response data trait
    use ControllerResponseDataTrait;

    /**
     * collection get
     * @Security("has_role('ROLE_USER_SIMPLE')")
     * @Route("/", name="api_message_message", defaults={"_format": "json"}, methods={"GET"})
     */
    public function cget(Request $request): View
    {
        // Sort and pattern
        $page     = $request->query->get('page', 1);
        $limit    = $request->query->get('limit', 50);
        $pattern  = $request->query->get('pattern', []);
        $type     = $request->query->get('type', 'received');
        $sort     = $request->query->get('sort', ['created' => 'DESC']);

        if ('sent' == $type) { // Get entities
            $pattern['sender'] = $this->getUser();
            $entities = $this->em->findAndPaginate($pattern, $sort, $page, $limit);
        } else { // Get entities
            $entities = $this->em->findReceivedByUser($this->getUser(), $sort, $page, $limit);
        }
        
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
     * @Route("/{id<\d+>}", name="api_message_message_show", defaults={"_format": "json"}, methods={"GET"})
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
     * @Security("has_role('ROLE_USER_SIMPLE')")
     * @Route("/", name="api_message_message_new", defaults={"_format": "json"}, methods={"POST"})
     */
    public function new(Request $request)
    {
        // Create entity
        $entity = $this->em->createEntity();

        // Add sender
        $entity->setBroadcasted(false)
                ->setSender($this->getUser())
                ->getLocations()->add($this->getUser()->getProfile()->getLocation());

        // Create form
        $form = $this->createForm($this->em->getFormType(), $entity, ['context' => MessageType::API_CONTEXT]);

        // Handle request
        $form->handleRequest($request);

        // Get response data
        $resData = $this->getResponseData();
        
        // If submitted and valided
        if ($form->isSubmitted() && $form->isValid())
        {
            // Get videos
            $videos = $entity->getVideos();
            
            // Create entity
            $this->em->create($entity);

            // Return view
            return $this->view($resData, Response::HTTP_NO_CONTENT);
        }

        // Add form to response data
        $resData->set('error', true);
        $resData->set('errors', \App\Normalizer\FormErrorNormalizer::normalizeErrors($form));

        // Return view
        return $this->view($resData, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Single get
     * @Security("has_role('ROLE_USER_SIMPLE')")
     * @Route("/count", name="api_message_message_count", defaults={"_format": "json"}, methods={"GET"})
     */
    public function countMsg(Request $request)
    {
        // Get response data
        $resData = $this->getResponseData();

        // Get message count
        $sent = $this->em->countSentByUser($this->getUser());
        $received = $this->em->countReceivedByUser($this->getUser());

        // Add form to response data
        $resData->set('total', 2);
        $resData->set('data', ['received' => $received, 'sent' => $sent]);

        //Create view
        $view = $this->view($resData, Response::HTTP_OK);
        
        // Render view
        return $view;
    }
}
