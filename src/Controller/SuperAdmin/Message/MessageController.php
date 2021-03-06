<?php

namespace App\Controller\SuperAdmin\Message;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Message\Message;
use App\Service\Message\MessageManager;

/**
 * MessageController 
 *
 * @Route("/message")
 */ 
class MessageController extends AbstractController
{
    /**
    * Entity manager
    */
    private $em;

    public function __construct(MessageManager $entityManager)
    {
        $this->em = $entityManager;
    }


    /**
     * @Route("/{page<\d+>?1}/{limit<\d+>?50}", name="super_admin_message_message")
     */
    public function index(Request $request, $page = 1, $limit = 50): Response
    {
        // Sort and pattern
        $pattern = $request->query->get('pattern', array());
        $sort 	 = $request->query->get('sort', array('created' => 'DESC'));

        // Get entities
        $entities = $this->em->findAndPaginate($pattern, $sort, $page, $limit);

        // Render view
        return $this->render("{$this->em->getBaseTemplateName()}/message/index.html.twig", [
            'sort' => $sort,
            'page' => $page,
            'limit' => $limit,
            'entities' => $entities,
        ]);
    }

    /**
     * @Route("/new", name="super_admin_message_message_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {	
    	// Create entity
        $entity = $this->em->createEntity();

        // Create form
        $form = $this->createForm($this->em->getFormType(), $entity)
            		->add('saveAndCreateNew', SubmitType::class);

        // Handle request
        $form->handleRequest($request);

        // Test isSubmitted()
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Add sender
            $entity->setSender($this->getUser());

            // Create entity
            $this->em->create($entity);

            // Flash messages are used to notify the user about the result
            $this->addFlash('success', 'Element ajouté avec succès');

            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute("{$this->em->getBaseRouteName()}_new");
            }

            return $this->redirectToRoute("{$this->em->getBaseRouteName()}_show", ["id" => $entity->getId()]);
        }

        return $this->render("{$this->em->getBaseTemplateName()}/message/new.html.twig", [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}/show", name="super_admin_message_message_show", methods={"GET"})
     */
    public function show(Request $request, Message $entity): Response
    {
        return $this->render("{$this->em->getBaseTemplateName()}/message/show.html.twig", [
            'entity' => $entity,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="super_admin_message_message_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Message $entity): Response
    {
        // Create form
        $form = $this->createForm($this->em->getFormType(), $entity);

        // Handle request
        $form->handleRequest($request);

        // Test isSubmitted()
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Create entity
            $this->em->update($entity);

            $this->addFlash('success', 'Element modifié avec succès');

            return $this->redirectToRoute("{$this->em->getBaseRouteName()}_edit", ['id' => $entity->getId()]);
        }

        return $this->render("{$this->em->getBaseTemplateName()}/message/edit.html.twig", [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}/delete", name="super_admin_message_message_delete", methods={"POST"})
     */
    public function delete(Request $request, Message $entity): Response
    {
        // Test if come from delete form
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute($this->em->getBaseRouteName());
        }

        // Create entity
        $this->em->delete($entity);

        $this->addFlash('success', 'Element effacé avec succès');

        return $this->redirectToRoute($this->em->getBaseRouteName());
    }
}
