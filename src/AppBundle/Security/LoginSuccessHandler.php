<?php

namespace AppBundle\Security;

use AppBundle\Services\UserHomeDirService;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Lsw\ApiCallerBundle\Caller\ApiCallerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Lsw\ApiCallerBundle\Call\HttpGetJson;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface {

    protected $router;
    protected $authorizationChecker;
    protected $apiCaller;
    protected $userTokens;
    protected $session;

    public function __construct(Router $router, AuthorizationChecker $authorizationChecker, ApiCallerInterface $apiCaller, UserHomeDirService $userHomeDirService, Session $session)
    {
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
        $this->apiCaller = $apiCaller;
        $this->userTokens = $userHomeDirService;
        $this->session = $session;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
        $user = $token->getUser();
        $userToken = $this->userTokens->getToken($user);
        $this->session->set('userToken',$userToken);
        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            $response = new RedirectResponse($this->router->generate('app_index_user'));
        } else if ($this->authorizationChecker->isGranted('ROLE_USER')) {
            $response = new RedirectResponse($this->router->generate('app_index_user'));
        }

        $response = new RedirectResponse($this->router->generate('app_index_user'));

        return $response;
    }

}