<?php
/**
 * Created by PhpStorm.
 * User: MASSENI
 * Date: 03/04/2018
 * Time: 15:19
 */

use Symfony\Component\Security\Core\User\UserProviderInterface;

class WebserviceUserProvider implements UserProviderInterface
{

    public function loadUserByUsername($username)
    {
        // TODO: Implement loadUserByUsername() method.

       // $userData = $this->
    }

    public function refreshUser(\Symfony\Component\Security\Core\User\UserInterface $user)
    {
        // TODO: Implement refreshUser() method.
    }

    public function supportsClass($class)
    {
        // TODO: Implement supportsClass() method.
    }
}