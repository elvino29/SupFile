<?php
/**
 * Created by PhpStorm.
 * User: KEVIN-PC
 * Date: 31/05/2018
 * Time: 14:01
 */

namespace AppBundle\Services;


use CoreBundle\Entity\Directory;

use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserHomeDirService
{
    protected $em;
    private $container;
    private $conteneur;

    // We need to inject this variables later.
    public function __construct(EntityManagerInterface $entityManager, \Psr\Container\ContainerInterface $container, \Symfony\Component\DependencyInjection\ContainerInterface $conteneur)
    {
        $this->em = $entityManager;
        $this->container = $container;
        $this->conteneur = $conteneur;
    }
    public function createHomeDir(UserInterface $user){

        $path = 'Dossier/'.$user->getId();



        $folder = new Directory();


        $fileSystem = new Filesystem();  //Appel de manipulation des fichiers system
        $folder->setName('..');
        $folder->setActive(true);
        $folder->setUser($user);
        $folder->setPath($path);
        $folder->setCreatedAt(new \DateTime());
        $folder->setUpdateAt(new \DateTime());
        $folder->setToken(uniqid());
        $folder->setShared(false);

        //  création du dossier utilisateur en physique
        try{
            if($fileSystem->exists($path))
            {
                return new JsonResponse(['message'=> 'Directory already exists !'], Response::HTTP_NOT_FOUND);
            }
            $fileSystem->mkdir($path, 0700);
        }catch (IOExceptionInterface $exception){
            return new JsonResponse(['message'=> 'Values Error !'], Response::HTTP_NOT_FOUND);
        }

        $this->em->persist($folder);
        $this->em->flush();
    }

    public  function getToken(UserInterface $user){

        return $this->container->get('lexik_jwt_authentication.encoder')
            ->encode([
                'username' => $user->getUsername(),
                'exp' => $this->getTokenExpiration(),
            ]);
    }


    public function getTokenExpiration(){


        $expiration = $this->conteneur->getParameter('lexik_jwt_authentication.token_ttl');
        $now = new \DateTime();
        $now->add(new \DateInterval('PT'.$expiration.'S'));
        return $now->format('U');


    }

}