<?php

namespace AppBundle\Security;

use Lsw\ApiCallerBundle\Caller\ApiCallerInterface;
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

    public function __construct(Router $router, AuthorizationChecker $authorizationChecker, ApiCallerInterface $apiCaller) {
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
        $this->apiCaller = $apiCaller;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
        $baseUrl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath() . '/webservice/login';
        $parameters = array(
            'username' => 'kevindoh26@gmail.com',
            'password' => 'kevindoh29'
        );

        //dump($this->apiCaller->call(new HttpGetJson($baseUrl, $request)));

        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            $response = new RedirectResponse($this->router->generate('app_index_user'));
        } else if ($this->authorizationChecker->isGranted('ROLE_USER')) {
            $response = new RedirectResponse($this->router->generate('app_index_user'));
        }

        $response = new RedirectResponse($this->router->generate('app_index_user'));

        return $response;
    }

}