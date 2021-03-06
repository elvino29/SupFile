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
    use \CoreBundle\Helpers\Formated\FileFormatedHelper;
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
        $file = $em->getRepository('CoreBundle:File')->find($request->get('id'));

        $path = $file->getPath();

        $fileSystem = new Filesystem();
        //  verifie si le fichier existe et on le télécharge sinon un msg d'erreur
        try{
            if($fileSystem->exists($path))
            {

                return $this->get('nzo_file_downloader')->downloadFile($path, $file->getName().'.'.$file->getType(), false);
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
        $file->setToken(uniqid());
        $file->setShared(false);

        $file->setFile($request->files->get('file'));

        $file->upload($folder);

        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($file);
        $em->flush();

        return new JsonResponse(['message'=> 'Upload Succeded !'], Response::HTTP_OK);
    }






    /**
     * @Rest\Post("/file/{id}/rename")
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

        $path = $files->getPath();

        $fileSystem = new Filesystem();

        $newPath = $files->getDirectory()->getCreateFolderDir();

        try {
            if ($fileSystem->exists($path)) {

                $newname = $request->get('newname');
                $fileSystem->rename($path, $newPath.'/'.$newname.'.'.$files->getType());
                $files->setName($request->get('newname'));
                $files->setPath($newPath.'/'.$newname.'.'.$files->getType());
                $em->merge($files);
                $em->flush();
                return new JsonResponse(['message' => 'Rename Succeded !'], Response::HTTP_OK);
            }
        } catch (IOExceptionInterface $exception) {
            return new JsonResponse(['message' => 'New name Error !'], Response::HTTP_NOT_FOUND);
        }

    }

//supprimer un fichier
    /**
     * @Rest\Delete("/file/remove")
     */

        public function removeFile(Request $request)
    {
        $user = $this->get("core_bundle.userprovider")
            ->loadUserByToken($request->headers->get('authorization'));
        if(!$user instanceof User) {
            return $user;
        }
        $em = $this->getDoctrine()->getManager();
        $file = $em->getRepository('CoreBundle:File')->find($request->get('id'));

        $file_path = $file->getPath() ;
        if(file_exists($file_path))
            unlink($file_path);

        if ($file) {
            $em->remove($file);
            $em->flush();
        }
        return new JsonResponse(['message' => 'Delete Succeded !'], Response::HTTP_OK);
    }


    /**
     * @Rest\post("/file/share")
     */
    public function shareAction(Request $request){

        $user = $this->get("core_bundle.userprovider")
            ->loadUserByToken($request->headers->get('authorization'));
        if(!$user instanceof User) {
            return $user;
        }

        $em = $this->getDoctrine()
            ->getManager();

        $file = $em->getRepository('CoreBundle:File')
            ->find($request->get('file_id'));

        $file->setShared(true);

        $em->merge($file);
        $em->flush();

        return new JsonResponse([
            'token' => $file->getToken(),
        ]);
    }

    /**
     * @Rest\get("/file/share/{id}")
     *
     * requirements = {"id" = "\d+"}
     */
    public function getShareFolder(Request $request){

        $user = $this->get("core_bundle.userprovider")
            ->loadUserByToken($request->headers->get('authorization'));
        if(!$user instanceof User) {
            return $user;
        }

        $em = $this->getDoctrine()
            ->getManager();

        $file = $em->getRepository('CoreBundle:File')->findOneBy(['token' => $request->get('id')]);

        if(!$file->getShared()) {

            return new JsonResponse([
                'error' => 'this file is not shared',
            ]);
        }



        return new JsonResponse($this->getFileFormat($file));
    }
}