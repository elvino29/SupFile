<?php
/**
 * Created by PhpStorm.
 * User: KEVIN-PC
 * Date: 19/03/2018
 * Time: 15:28
 */

namespace CoreBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CoreBundle\Entity\User;
use CoreBundle\Entity\File;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
   // public function indexAction(){

   // }

    // Télécharger des fichiers

    /**
     * @Rest\Get("/file/download/")
     * @return JsonResponse
     */
    public function downloadFileAction(Request $request){

        $user = $this->get("core_bundle.userprovider")
            ->loadUserByToken($request->headers->get('authorization'));
        if(!$user instanceof User) {
            return $user;
        }
   //création du path
        $em = $this->getDoctrine()->getManager();
        $files = $em->getRepository('CoreBundle:File')->find($request->get('id'));
        $file =  new File();
        $path = $file->getFilePath($files);


        $fileSystem = new Filesystem();
        //  verifie si le fichier existe et on le télécharge sinon un msg d'erreur
        try{
            if($fileSystem->exists($path))
            {
                return $this->get('nzo_file_downloader')->downloadFile($file->getFilePath($files), $files->getName().'.'.$files->getType(), false);
            }
            return new JsonResponse(['message'=> 'File Not exists !'], Response::HTTP_NOT_FOUND);
        }catch (IOExceptionInterface $exception){
            return new JsonResponse(['message'=> $exception->getMessage()], Response::HTTP_NOT_FOUND);
        }

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






    /**
     * @Rest\Put("/file/{id}")
     */
    public function putFileAction(Request $request){

        $file =  new File();
        $user = $this->get("core_bundle.userprovider")
            ->loadUserByToken($request->headers->get('authorization'));
        if(!$user instanceof User) {
            return $user;
        }


        //création du path
        $em = $this->getDoctrine()->getManager();
        $files = $em->getRepository('CoreBundle:File')->find($request->get('id'));
        $file =  new File();
        $path = $file->getFilePath($files);

        $fileSystem = new Filesystem();


    }
}