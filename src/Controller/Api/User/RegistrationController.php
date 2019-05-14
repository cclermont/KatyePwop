<?php

namespace App\Controller\Api\User;

use FOS\RestBundle\View\View;
use FOS\UserBundle\FOSUserEvents;
use FOS\RestBundle\Context\Context;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


use App\Entity\User\User;
use App\Form\User\RegistrationFormType;
use App\Controller\Api\ControllerResponseDataTrait;

/**
 * RegistrationController 
 *
 * @Route("/user/registration")
 */ 
class RegistrationController extends FOSRestController
{
    private $eventDispatcher;
    private $userManager;
    private $tokenStorage;

    public function __construct(EventDispatcherInterface $eventDispatcher, UserManagerInterface $userManager, TokenStorageInterface $tokenStorage)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->userManager = $userManager;
        $this->tokenStorage = $tokenStorage;
    }

    // Response data trait
    use ControllerResponseDataTrait;

    /**
     * @Route("/register", name="api_user_registration_register", defaults={"_format": "json"}, methods={"POST"})
     */
    public function register(Request $request)
    {
        $user = $this->userManager->createUser();

        $user->setEnabled(true)
            ->addRole(User::ROLE_USER_SIMPLE);

        $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, new GetResponseUserEvent($user, $request));

        $form = $this->createForm(RegistrationFormType::class, $user, ['method' => 'POST']);

        $form->handleRequest($request);

        // Get response data
        $resData = $this->getResponseData();

        if ($form->isSubmitted()) {
            
            if ($form->isValid()) {

                $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, new FormEvent($form, $request));

                $this->userManager->updateUser($user);

                $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, 
                    new FilterUserResponseEvent($user, $request, new Response()));

                // Return view
                return $this->view($resData, Response::HTTP_NO_CONTENT);
            }

            $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, new FormEvent($form, $request));
        }

        // Add form to response data
        $resData->set('error', true);
        $resData->set('errors', $form->getErrors(true));

        // Return view
        return $this->view($resData, Response::HTTP_BAD_REQUEST);
    }
}
