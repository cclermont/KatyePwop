<?php

namespace App\Controller\Frontend\User;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\Routing\Annotation\Route;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Event\GetResponseNullableUserEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ResettingController extends AbstractController
{
  	/**
  	* Properties
  	*/
    private $eventDispatcher;
    private $formFactory;
    private $userManager;
    private $tokenGenerator;
    private $mailer;

    /**
     * @var int
     */
    private $retryTtl;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param FactoryInterface         $formFactory
     * @param UserManagerInterface     $userManager
     * @param TokenGeneratorInterface  $tokenGenerator
     * @param MailerInterface          $mailer
     * @param int                      $retryTtl
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, FactoryInterface $formFactory, UserManagerInterface $userManager, TokenGeneratorInterface $tokenGenerator, MailerInterface $mailer, $retryTtl)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory = $formFactory;
        $this->userManager = $userManager;
        $this->tokenGenerator = $tokenGenerator;
        $this->mailer = $mailer;
        $this->retryTtl = $retryTtl;
    }

    /**
     * Request reset user password: show form.
     *
     * @Route("/request", name="fos_user_resetting_request", methods={"GET"})
     * @Route("/request", name="frontend_user_resetting_request", methods={"GET"})
     */
    public function request()
    {
        return $this->render('frontend/user/resetting/request.html.twig', [
            'controller_name' => 'ResettingController',
        ]);
    }

    /**
     * Request reset user password: submit form and send email.
     *
     * @Route("/send-email", name="fos_user_resetting_send_email", methods={"POST"})
     * @Route("/send-email", name="frontend_user_resetting_send_email", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function sendEmail(Request $request)
    {
        $username = $request->request->get('username');

        $user = $this->userManager->findUserByUsernameOrEmail($username);

        $event = new GetResponseNullableUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        if (null !== $user && !$user->isPasswordRequestNonExpired($this->retryTtl)) {
            $event = new GetResponseUserEvent($user, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::RESETTING_RESET_REQUEST, $event);

            if (null !== $event->getResponse()) {
                return $event->getResponse();
            }

            if (null === $user->getConfirmationToken()) {
                $user->setConfirmationToken($this->tokenGenerator->generateToken());
            }

            $event = new GetResponseUserEvent($user, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_CONFIRM, $event);

            if (null !== $event->getResponse()) {
                return $event->getResponse();
            }

            $this->mailer->sendResettingEmailMessage($user);
            $user->setPasswordRequestedAt(new \DateTime());
            $this->userManager->updateUser($user);

            $event = new GetResponseUserEvent($user, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_COMPLETED, $event);

            if (null !== $event->getResponse()) {
                return $event->getResponse();
            }
        } else if (null === $user) {
        	$this->addFlash('error', "Cet utilisateur($username) n'existe pas.");
        	return $this->redirectToRoute("frontend_user_resetting_request");
        } else if ($user->isPasswordRequestNonExpired($this->retryTtl)) {
        	$this->addFlash('error', "Une demande est deja en cours, vous devez attendre avant d'en faire une autre.");
        	return $this->redirectToRoute("frontend_user_resetting_request");
        }

        return new RedirectResponse($this->generateUrl('fos_user_resetting_check_email', array('username' => $username)));
    }

    /**
     * Tell the user to check his email provider.
     *
     * @Route("/check-email", name="fos_user_resetting_check_email", methods={"GET"})
     * @Route("/check-email", name="frontend_user_resetting_check_email", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function checkEmail(Request $request)
    {
        $username = $request->query->get('username');

        if (empty($username)) {
            // the user does not come from the sendEmail action
            return new RedirectResponse($this->generateUrl('fos_user_resetting_request'));
        }

        return $this->render('frontend/user/resetting/check_email.html.twig', [
            'tokenLifetime' => ceil($this->retryTtl / 3600),
        ]);
    }

    /**
     * Reset user password.
     *
     * @Route("/reset/{token}", name="fos_user_resetting_reset", methods={"GET", "POST"})
     * @Route("/reset/{token}", name="frontend_user_resetting_reset", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param string  $token
     *
     * @return Response
     */
    public function reset(Request $request, $token)
    {
        $user = $this->userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            return new RedirectResponse($this->container->get('router')->generate('fos_user_security_login'));
        }

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::RESETTING_RESET_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = new FormEvent($form, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::RESETTING_RESET_SUCCESS, $event);

            $this->userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
            	if ($user->isAdmin()) {
                	$url = $this->generateUrl('admin_dashboard');
            	} else if ($user->isSuperAdmin()) {
                	$url = $this->generateUrl('super_admin_dashboard');
            	} else {
                	$url = $this->generateUrl('frontend_home_home');
            	}
            	
                $response = new RedirectResponse($url);
            }

            $this->eventDispatcher->dispatch(
                FOSUserEvents::RESETTING_RESET_COMPLETED,
                new FilterUserResponseEvent($user, $request, $response)
            );

            return $response;
        }

        return $this->render('frontend/user/resetting/reset.html.twig', [
            'token' => $token,
            'form' => $form->createView(),
        ]);
    }
}
