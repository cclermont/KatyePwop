<?php

/**
 * @Author: Evens Pierre
 * @Date:   2017-02-09 17:16:26
 * @Last Modified by:   evens
 * @Last Modified time: 2017-04-14 11:18:19
 */

namespace App\Handler\User;

use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;


use App\Entity\User\User;


class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected $router;
	protected $authorizationChecker;

    // Use traits
    use TargetPathTrait;
    
    public function __construct(Router $router, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->router = $router;
		$this->authorizationChecker = $authorizationChecker;
    }
	
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {   
        $providerKey = $token->getProviderKey();
        $targetPath = $this->getTargetPath($request->getSession(), $providerKey);

        if ($this->authorizationChecker->isGranted(User::ROLE_ADMIN) || 
            $this->authorizationChecker->isGranted(User::ROLE_OPERATOR)) { // Admin, Operator
            $url = $this->router->generate('admin_dashboard');
        } else if ($this->authorizationChecker->isGranted(User::ROLE_SUPER_ADMIN)) { // Super admin
            $url = $this->router->generate('super_admin_dashboard');
		} else { // User
            $url = $this->router->generate('frontend_home_home');
        }
        
        $url = empty($targetPath) ? $url : $targetPath;

        return new RedirectResponse($url);
    }
}
