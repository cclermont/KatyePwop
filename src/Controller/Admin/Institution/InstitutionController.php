<?php

namespace App\Controller\Admin\Institution;

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
     * @Route("/show", name="admin_institution_institution_show", methods={"GET"})
     */
    public function show(Request $request): Response
    {
        $entity = $this->em->findByUser($this->getUser());
        
        if (null == $entity) {
            $this->createNotFoundException("Aucune institution trouvée");
        }

        // Security check
        $this->denyAccessUnlessGranted('show', $entity, "Vous ne pouvez pas voir cette institution");

        return $this->render("{$this->em->getBaseTemplateName('admin')}/institution/show.html.twig", [
            'entity' => $entity,
        ]);
    }

    /**
     * @Route("/edit", name="admin_institution_institution_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request): Response
    {
        $entity = $this->em->findByUser($this->getUser());
        
        if (null == $entity) {
            $this->createNotFoundException("Aucune institution trouvée");
        }

        // Security check
        $this->denyAccessUnlessGranted('edit', $entity, "Vous ne pouvez pas editer cette institution");

        // Create form
        $form = $this->createForm($this->em->getFormType(), $entity, [
            'context' => 'admin',
            'admins' => $this->em->getAdminsId($this->getUser()), 
            'members' => $this->em->getMembersId($this->getUser())]
         );

        // Handle request
        $form->handleRequest($request);

        // Test isSubmitted()
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Create entity
            $this->em->update($entity);

            $this->addFlash('success', 'Element modifié avec succès');

            return $this->redirectToRoute("{$this->em->getBaseRouteName('admin')}_edit", ['id' => $entity->getId()]);
        }

        return $this->render("{$this->em->getBaseTemplateName('admin')}/institution/edit.html.twig", [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }
}
