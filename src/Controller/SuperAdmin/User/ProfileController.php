<?php

namespace App\Controller\SuperAdmin\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\User\Profile;
use App\Form\User\ProfileType;
use App\Service\User\UserManager;

/**
 * ProfileController 
 *
 * @Route("/user/profile")
 */ 
class ProfileController extends AbstractController
{
    /**
    * Entity manager
    */
    private $em;

    public function __construct(UserManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/edit", name="super_admin_user_profile_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request): Response
    {
    	// Get user profile
    	$user = $this->getUser();
    	$entity = $user->getProfile();
    	$entity = $entity ?: new Profile();

        // Create form
        $form = $this->createForm(ProfileType::class, $entity);

        // Handle request
        $form->handleRequest($request);

        // Test isSubmitted()
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Set profile to user
            $user->setProfile($entity);

            // Update entity
            $this->em->update($user);

            $this->addFlash('success', 'Profil modifié avec succès');

            return $this->redirectToRoute("{$this->em->getBaseRouteName()}_profile_edit");
        }

        return $this->render("{$this->em->getBaseTemplateName()}/profile/edit.html.twig", [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }
}
