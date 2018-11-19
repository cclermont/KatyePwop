<?php

namespace App\Controller\SuperAdmin\Institution;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Institution\Institution;
use App\Service\Institution\InstitutionManager;

/**
 * InstitutionController 
 *
 * @Route("/institution")
 */ 
class InstitutionController extends AbstractController
{
    /**
    * Entity manager
    */
    private $em;

    public function __construct(InstitutionManager $entityManager)
    {
        $this->em = $entityManager;
    }


    /**
     * @Route("/{page<\d+>?1}/{limit<\d+>?50}", name="super_admin_institution_institution")
     */
    public function index(Request $request, $page = 1, $limit = 50): Response
    {
        // Sort and pattern
        $pattern = $request->query->get('pattern', array());
        $sort 	 = $request->query->get('sort', array('created' => 'DESC'));

        // Get entities
        $entities = $this->em->findAndPaginate($pattern, $sort, $page, $limit);

        // Render view
        return $this->render("{$this->em->getBaseTemplateName()}/institution/index.html.twig", [
            'sort' => $sort,
            'page' => $page,
            'limit' => $limit,
            'entities' => $entities,
        ]);
    }

    /**
     * @Route("/new", name="super_admin_institution_institution_new", methods={"GET", "POST"})
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
            
            // Add Admin to members and
            $admin = $entity->getAdmin();
            
            if(null != $admin && !$entity->getMembers()->contains($admin)){
                // Set default password
                $admin->setPlainPassword(md5(rand()));
                $entity->addMember($admin);
            }

            // Create entity
            $this->em->create($entity);

            // Flash messages are used to notify the user about the result
            $this->addFlash('success', 'Element ajouté avec succès');

            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute("{$this->em->getBaseRouteName()}_new");
            }

            return $this->redirectToRoute("{$this->em->getBaseRouteName()}_show", ["id" => $entity->getId()]);
        }

        return $this->render("{$this->em->getBaseTemplateName()}/institution/new.html.twig", [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}/show", name="super_admin_institution_institution_show", methods={"GET"})
     */
    public function show(Request $request, Institution $entity): Response
    {
        return $this->render("{$this->em->getBaseTemplateName()}/institution/show.html.twig", [
            'entity' => $entity,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="super_admin_institution_institution_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Institution $entity): Response
    {
        // Create form
        $form = $this->createForm($this->em->getFormType(), $entity);

        // Handle request
        $form->handleRequest($request);

        // Test isSubmitted()
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Add Admin to members
            if($entity->getAdmin() && !$entity->getMembers()->contains($entity->getAdmin())){
                $entity->addMember($entity->getAdmin());
            }

            // Create entity
            $this->em->update($entity);

            $this->addFlash('success', 'Element modifié avec succès');

            return $this->redirectToRoute("{$this->em->getBaseRouteName()}_edit", ['id' => $entity->getId()]);
        }

        return $this->render("{$this->em->getBaseTemplateName()}/institution/edit.html.twig", [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}/delete", name="super_admin_institution_institution_delete", methods={"POST"})
     */
    public function delete(Request $request, Institution $entity): Response
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
