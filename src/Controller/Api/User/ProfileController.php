<?php

namespace App\Controller\Api\User;

use FOS\RestBundle\View\View;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Context\Context;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Doctrine\Common\Collections\ArrayCollection;
use Nelmio\ApiDocBundle\Annotation\Security as NelmioSecurity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Entity\User\Profile;
use App\Form\User\ProfileType;
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
     *
     * @SWG\Tag(name="Profile")
     * @NelmioSecurity(name="Bearer")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the profile of the authenticated user",
     *     @Model(type=Profile::class, groups={"show"})
     * )
     *
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
     * Edit
     *
     * @SWG\Tag(name="Profile")
     * @NelmioSecurity(name="Bearer")
     * @SWG\Put(
     *     summary="Edit",
     *     operationId="edit",
     *     description="Edit the profile of the authenticated user",
     *     produces={"application/json"},
     *          @SWG\Parameter(name="firstname", in="body", schema={"type":"string"}, description="User firstname"),
     *          @SWG\Parameter(name="lastname", in="body", schema={"type":"string"}, description="User lastname"),
     *          @SWG\Parameter(name="gender", in="body", schema={"type":"string"}, description="User gender"),
     *          @SWG\Parameter(name="phone", in="body", schema={"type":"string"}, description="User phone number"),
     *          @SWG\Parameter(name="birthdate", in="body", schema={"type":"string"}, description="User birthdate"),
     *          @SWG\Parameter(name="image", in="body", schema={"type":"file"}, description="User avatar"),
     *          @SWG\Parameter(name="location", in="body", schema={"type":"integer"}, description="User location")
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Edit the profile of the authenticated user"
     * )
     *
     * @Security("has_role('ROLE_USER_SIMPLE')")
     * @Route("/", name="api_user_profile_edit", defaults={"_format": "json"}, methods={"PUT"})
     */
    public function edit(Request $request)
    {
        // Get user profile
        $user = $this->getUser();
        $entity = $user->getProfile();

        // Create form
        $form = $this->createForm(ProfileType::class, $entity, ['context' => ProfileType::API_CONTEXT, 'method' => 'PUT']);

        // Handle request
        $form->handleRequest($request);

        // Get response data
        $resData = $this->getResponseData();
        
        // If submitted and valided
        if ($form->isSubmitted() && $form->isValid())
        {
            // Set profile to user
            $user->setProfile($entity);

            // Update entity
            $this->em->update($user);

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
