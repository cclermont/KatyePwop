<?php

namespace App\Controller\Admin\Message;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Message\Schedule;
use App\Service\Message\ScheduleManager;
use App\Service\Institution\InstitutionManager;

/**
 * ScheduleController 
 *
 * @Route("/schedule")
 */ 
class ScheduleController extends AbstractController
{
    /**
    * Entity manager
    */
    private $em;
    private $institutionManager;

    public function __construct(ScheduleManager $entityManager, InstitutionManager $institutionManager)
    {
        $this->em = $entityManager;
        $this->institutionManager = $institutionManager;
    }


    /**
     * @Route("/", name="admin_message_schedule")
     */
    public function index(Request $request, $page = 1, $limit = 50): Response
    {
        // Sort and pattern
        $pattern = $request->query->get('pattern', array());
        $sort 	 = $request->query->get('sort', array('created' => 'DESC'));

        // Get entities
         $entities = $this->em->findAndPaginate($pattern, $sort, $page, $limit);

        // Render view
        return $this->render("{$this->em->getBaseTemplateName('admin')}/schedule/index.html.twig", [
            'sort' => $sort,
            'page' => $page,
            'limit' => $limit,
            'entities' => $entities,
        ]);
    }

    /**
     * @Route("/new", name="admin_message_schedule_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {	
    	// Create entity
        $entity = $this->em->createEntity();
            
        // Get institution
        $institution = $this->institutionManager->findByUser($this->getUser());

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

            return $this->redirectToRoute("{$this->em->getBaseRouteName('admin')}", ["id" => $entity->getId()]);
        }

        return $this->render("{$this->em->getBaseTemplateName('admin')}/schedule/new.html.twig", [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="admin_message_schedule_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Schedule $entity): Response
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

            return $this->redirectToRoute("{$this->em->getBaseRouteName('admin')}_edit", ['id' => $entity->getId()]);
        }

        return $this->render("{$this->em->getBaseTemplateName('admin')}/schedule/edit.html.twig", [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}/delete", name="admin_message_schedule_delete", methods={"POST"})
     */
    public function delete(Request $request, Schedule $entity): Response
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
