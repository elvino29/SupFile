<?php
/**
 * Created by PhpStorm.
 * User: KEVIN-PC
 * Date: 30/05/2018
 * Time: 00:22
 */

namespace AppBundle\EventListener;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class LogoutListener implements LogoutSuccessHandlerInterface
{

    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function onLogoutSuccess(Request $request)
    {
       return new RedirectResponse($this->router->generate('app_index'));
    }
}