<?php

namespace App\Controller\Admin\Message;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Message\Message;
use App\Service\Message\MessageManager;
use App\Service\Institution\InstitutionManager;

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
    private $institutionManager;

    public function __construct(MessageManager $entityManager, InstitutionManager $institutionManager)
    {
        $this->em = $entityManager;
        $this->institutionManager = $institutionManager;
    }


    /**
     * @Route("/{type<received|sent>?received}/{page<\d+>?1}/{limit<\d+>?50}", name="admin_message_message")
     */
    public function index(Request $request, $type = 'received', $page = 1, $limit = 50): Response
    {
        // Sort and pattern
        $pattern = $request->query->get('pattern', array());
        $sort 	 = $request->query->get('sort', array('created' => 'DESC'));

        // Get institution
        $institution = $this->institutionManager->findByUser($this->getUser());

        if ('sent' == $type) {
            // Get entities
            $pattern['senderInstitution'] = $institution;
            $entities = $this->em->findAndPaginate($pattern, $sort, $page, $limit);
        } else {
            // Get entities
            $entities = $this->em->findReceivedByInstitution($institution, $sort, $page, $limit);
        }

        // Render view
        return $this->render("{$this->em->getBaseTemplateName('admin')}/message/index.html.twig", [
            'type' => $type,
            'sort' => $sort,
            'page' => $page,
            'limit' => $limit,
            'entities' => $entities,
        ]);
    }

    /**
     * @Route("/new", name="admin_message_message_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {	
    	// Create entity
        $entity = $this->em->createEntity();
            
        // Get institution
        $institution = $this->institutionManager->findByUser($this->getUser());

        // Add sender
        $entity->setSender($this->getUser())
                ->setBroadcasted(true)
                ->setSenderInstitution($institution);

        // Create form
        $form = $this->createForm($this->em->getFormType(), $entity, ['institution' => $institution])
            		->add('saveAndCreateNew', SubmitType::class);

        // Handle request
        $form->handleRequest($request);

        // Test isSubmitted()
        if ($form->isSubmitted() && $form->isValid()) {

            // Create entity
            $this->em->create($entity);

            // Flash messages are used to notify the user about the result
            $this->addFlash('success', 'Element ajouté avec succès');

            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute("{$this->em->getBaseRouteName('admin')}_new");
            }

            return $this->redirectToRoute("{$this->em->getBaseRouteName('admin')}_show", ["id" => $entity->getId()]);
        }

        return $this->render("{$this->em->getBaseTemplateName('admin')}/message/new.html.twig", [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}/show", name="admin_message_message_show", methods={"GET"})
     *
     * @IsGranted("show", subject="entity", message="Vous ne pouvez pas voir ce message")
     */
    public function show(Request $request, Message $entity): Response
    {
        return $this->render("{$this->em->getBaseTemplateName('admin')}/message/show.html.twig", [
            'entity' => $entity,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="admin_message_message_edit", methods={"GET", "POST"})
     *
     * @IsGranted("edit", subject="entity", message="Vous ne pouvez pas editer ce message")
     */
    public function edit(Request $request, Message $entity): Response
    {
        // Create form
        $form = $this->createForm($this->em->getFormType(), $entity, ['institution' => $institution]);

        // Handle request
        $form->handleRequest($request);

        // Test isSubmitted()
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Create entity
            $this->em->update($entity);

            $this->addFlash('success', 'Element modifié avec succès');

            return $this->redirectToRoute("{$this->em->getBaseRouteName('admin')}_edit", ['id' => $entity->getId()]);
        }

        return $this->render("{$this->em->getBaseTemplateName('admin')}/message/edit.html.twig", [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}/delete", name="admin_message_message_delete", methods={"POST"})
     *
     * @IsGranted("delete", subject="entity", message="Vous ne pouvez pas effacer ce message")
     */
    public function delete(Request $request, Message $entity): Response
    {
        // Test if come from delete form
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute($this->em->getBaseRouteName('admin'));
        }

        // Create entity
        $this->em->delete($entity);

        $this->addFlash('success', 'Element effacé avec succès');

        return $this->redirectToRoute($this->em->getBaseRouteName('admin'));
    }
}
