<?php

namespace App\Controller\Api\User;

use FOS\RestBundle\View\View;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\Event\GetResponseNullableUserEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use App\Controller\Api\ControllerResponseDataTrait;

/**
 * ResettingController 
 *
 * @Route("/user/resetting")
 */ 
class ResettingController extends FOSRestController
{
    /**
    * Properties
    */
    private $eventDispatcher;
    private $userManager;
    private $tokenGenerator;
    private $mailer;

    /**
     * @var int
     */
    private $retryTtl;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param UserManagerInterface     $userManager
     * @param TokenGeneratorInterface  $tokenGenerator
     * @param MailerInterface          $mailer
     * @param int                      $retryTtl
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, 
                                UserManagerInterface $userManager, 
                                TokenGeneratorInterface $tokenGenerator, 
                                MailerInterface $mailer, $retryTtl)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->userManager = $userManager;
        $this->tokenGenerator = $tokenGenerator;
        $this->mailer = $mailer;
        $this->retryTtl = $retryTtl;
    }

    // Response data trait
    use ControllerResponseDataTrait;

    /**
     * @Route("/send-email", name="api_user_resetting_send_email", defaults={"_format": "json"}, methods={"POST"})
     */
    public function sendEmail(Request $request)
    {
        $username = $request->request->get('username');

        $user = $this->userManager->findUserByUsernameOrEmail($username);

        $event = new GetResponseNullableUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_INITIALIZE, $event);

        // Get response data
        $resData = $this->getResponseData();

        if (null !== $user && !$user->isPasswordRequestNonExpired($this->retryTtl)) {
            
            $event = new GetResponseUserEvent($user, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::RESETTING_RESET_REQUEST, $event);

            if (null === $user->getConfirmationToken()) {
                $user->setConfirmationToken($this->tokenGenerator->generateToken());
            }

            $event = new GetResponseUserEvent($user, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_CONFIRM, $event);

            $this->mailer->sendResettingEmailMessage($user);
            $user->setPasswordRequestedAt(new \DateTime());
            $this->userManager->updateUser($user);

            $event = new GetResponseUserEvent($user, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_COMPLETED, $event);

            // Return view
            return $this->view($resData, Response::HTTP_NO_CONTENT);
        }

        // Add form to response data
        $resData->set('error', true);

        // Return view
        return $this->view($resData, Response::HTTP_BAD_REQUEST);
    }
}
