<?php

namespace App\Controller\Frontend\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use FOS\UserBundle\Controller\SecurityController as BaseSecurityController;

class SecurityController extends AbstractController
{
    /**
    * Token manager
    */
    private $tokenManager;

    public function __construct(CsrfTokenManagerInterface $tokenManager = null)
    {
        $this->tokenManager = $tokenManager;
    }

    /**
     * @Route("/{_locale<%app_locales%>?%locale%}/login", name="fos_user_security_login", methods={"GET","POST"})
     * @Route("/{_locale<%app_locales%>?%locale%}/login", name="frontend_user_security_login", methods={"GET","POST"})
     */
    public function index(Request $request)
    {
        /** @var $session Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->tokenManager
            ? $this->tokenManager->getToken('authenticate')->getValue()
            : null;

        return $this->render('frontend/user/security/index.html.twig', [
            'error' => $error,
            'csrf_token' => $csrfToken,
            'last_username' => $lastUsername,
        ]);
    }

    /**
     * @Route("/login_check", name="fos_user_security_check", methods={"POST"})
     * @Route("/login_check", name="frontend_user_security_check", methods={"POST"})
     */
    public function check()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    /**
     * @Route("/logout", name="fos_user_security_logout", methods={"GET","POST"})
     * @Route("/logout", name="frontend_user_security_logout", methods={"GET","POST"})
     */
    public function logout()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
}
