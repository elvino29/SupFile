<?php
/**
 * Created by PhpStorm.
 * User: KEVIN-PC
 * Date: 19/03/2018
 * Time: 15:28
 */

namespace CoreBundle\Controller;


use CoreBundle\Entity\File;
use CoreBundle\Entity\User;
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

class FileController extends Controller
{
    public function indexAction(){

    }

    public function getAllFileAction(){

    }

    public function downloadFileAction(){

    }
    /**
     * @Rest\Post("/upload/{id}")
     * requirements={"id" = "\d+"}
     */
    public function uploadFileAction($id, Request $request){

        $user = $this->get("core_bundle.userprovider")
            ->loadUserByToken($request->headers->get('authorization'));
        if(!$user instanceof User) {
            return $user;
        }

        $em = $this->getDoctrine()
            ->getManager();

        $folder = $em->getRepository('CoreBundle:Directory')
            ->find($id);

        $file = new File();

      // $file->getUploadPath($folder);
        $file->setCreatedAt(new \DateTime());
        $file->setUpdateAt(new \DateTime());

        $file->setFile($request->files->get('file'));

        $file->upload($folder);

        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($file);
        $em->flush();

        return new JsonResponse(['message'=> 'Upload Succeded !'], Response::HTTP_OK);
    }

}