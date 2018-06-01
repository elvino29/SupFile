<?php
/**
 * Created by PhpStorm.
 * User: MASSENI
 * Date: 03/04/2018
 * Time: 15:19
 */
namespace CoreBundle\Security\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class WebserviceUserProvider implements UserProviderInterface
{
    private $encoder;
    private $em;
    public function __construct(\Lexik\Bundle\JWTAuthenticationBundle\Encoder\DefaultEncoder $encoder, EntityManager $em)
    {
        $this->encoder = $encoder;
        $this->em = $em;
    }

    public function loadUserByUsername($username)
    {
       $user = $this->em->getRepository("CoreBundle:User")
            ->findByUsernameOrEmail($username);

        return $user;
    }

    public function loadUserByToken($token){

        $data =$this->encoder->decode($token);
        $user = $this->loadUserByUsername($data['username']);

        if (empty($user)){
            return new JsonResponse(['message'=> 'User not found !'], Response::HTTP_NOT_FOUND);
        }

        return $user;
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