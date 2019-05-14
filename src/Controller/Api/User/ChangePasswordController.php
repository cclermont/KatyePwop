<?php

namespace App\Controller\Api\User;

use FOS\RestBundle\View\View;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use App\Form\User\ChangePasswordFormType;
use App\Controller\Api\ControllerResponseDataTrait;

/**
 * ChangePasswordController 
 *
 * @Route("/user/change-password")
 */ 
class ChangePasswordController extends FOSRestController
{
    /**
     * Properties
     */
    private $userManager;
    private $eventDispatcher;

    public function __construct(UserManagerInterface $userManager,
                                EventDispatcherInterface $eventDispatcher)
    {
        $this->userManager = $userManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    // Response data trait
    use ControllerResponseDataTrait;

    /**
     * @Security("has_role('ROLE_USER_SIMPLE')")
     * @Route("/", name="api_user_change_password", defaults={"_format": "json"}, methods={"PUT"})
     */
    public function changePassword(Request $request): View
    {
        $user = $this->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $this->eventDispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, new GetResponseUserEvent($user, $request));

        $form = $this->createForm(ChangePasswordFormType::class, $user, ['method' => 'PUT']);

        $form->handleRequest($request);

        // Get response data
        $resData = $this->getResponseData();
        
        // If submitted and valided
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->eventDispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, new FormEvent($form, $request));

            $this->userManager->updateUser($user);

            $this->eventDispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, 
                                            new FilterUserResponseEvent($user, $request, new Response()));

            // Return view
            return $this->view($resData, Response::HTTP_NO_CONTENT);
        }

        // Add form to response data
        $resData->set('error', true);
        $resData->set('errors', $form->getErrors(true));
        // $resData->set('errors', \App\Normalizer\FormErrorNormalizer::normalizeErrors($form));

        // Return view
        return $this->view($resData, Response::HTTP_BAD_REQUEST);
    }
}
