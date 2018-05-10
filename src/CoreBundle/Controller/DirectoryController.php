<?php
/**
 * Created by PhpStorm.
 * User: KEVIN-PC
 * Date: 19/03/2018
 * Time: 17:41
 */

namespace CoreBundle\Controller;


use CoreBundle\Entity\User;
use CoreBundle\Entity\Directory;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DirectoryController extends Controller
{

    use \CoreBundle\Helpers\Formated\DirectoryFormatedHelper;
    /**
     * @Rest\Get("/folder/user/")
     *
     * @return JsonResponse
     */
    public function getUserFolderAction(Request $request){

        $user = $this->get("core_bundle.userprovider")
            ->loadUserByToken($request->headers->get('authorization'));
        if(!$user instanceof User) {
            return $user;
        }

        $em = $this->getDoctrine()
            ->getManager();

        $folders = $em->getRepository('CoreBundle:User')
                     ->getUserFolder($user->getId());

        return new JsonResponse($folders);
    }


    /**
     * @Rest\Get("/file/folder/{id}")
     * requirements={"id" = "\d+"}
     *
     * @param $id
     * @return JsonResponse
     */
    public function getUserFilesByFolderAction($id, Request $request){

       $user = $this->get("core_bundle.userprovider")
            ->loadUserByToken($request->headers->get('authorization'));
        if(!$user instanceof User) {
            return $user;
        }

        $em = $this->getDoctrine()
            ->getManager();

        $folder = $em->getRepository('CoreBundle:Directory')
            ->find($id);

        if($user->getId() == $folder->getUser()->getId()){
            $files = $em->getRepository('CoreBundle:Directory')
                ->getFolderAndFiles($id);

            return new JsonResponse($files);
        }else {
            return new JsonResponse(['message'=> 'This files is not yours'], Response::HTTP_NOT_FOUND);
        }
    }

    // creation de dossiers
      /**
      * @Rest\Post("/folder")
      */
    public function postFolderAction(Request $request){

        $user = $this->get("core_bundle.userprovider")
            ->loadUserByToken($request->headers->get('authorization'));
        if(!$user instanceof User) {
            return $user;
        }

        $folder = new Directory();

        $fileSystem = new Filesystem();  //Appel de manipulation des fichiers system
        $folder->setName($request->get('name'));
        $folder->setActive(true);
        $folder->setUser($user);
        $folder->setPath($folder->getAbsolutePath());
        $folder->setCreatedAt(new \DateTime());
        $folder->setUpdateAt(new \DateTime());

        $fileSystem->rename('/tmp/processed_video.ogg', '/path/to/store/video_647.ogg');
          
             //  création du dossier utilisateur en physique
        try{
            if($fileSystem->exists($folder->getAbsolutePath()))
            {
                return new JsonResponse(['message'=> 'Directory already exists !'], Response::HTTP_NOT_FOUND);
            }
            $fileSystem->mkdir($folder->getAbsolutePath(), 0700);
        }catch (IOExceptionInterface $exception){
            return new JsonResponse(['message'=> 'Values Error !'], Response::HTTP_NOT_FOUND);
        }

        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($folder);
        $em->flush();

        return new JsonResponse([
            'name' => $folder->getName(),
            'CreatedAt' => $folder->getCreatedAt()
        ]);
    }




}