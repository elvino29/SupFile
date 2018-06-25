<?php
/**
 * Created by PhpStorm.
 * User: rakotomalala
 * Date: 14/05/2018
 * Time: 16:14
 */

namespace AppBundle\Controller;


use CoreBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{

    use \CoreBundle\Helpers\Formated\DirectoryFormatedHelper;
    use \CoreBundle\Helpers\Formated\FileFormatedHelper;

    public function indexAction(){

      return $this->render('AppBundle:Home:index.html.twig');
    }

    public function toLoginAction(){
        return $this->render('AppBundle:Home:login.html.twig');
    }

    public function indexUserAction(){
       // get user folder and files
        $user = $this->getUser();
        $em = $this->getDoctrine()
            ->getManager();

        $root = $em->getRepository('CoreBundle:Directory')->getUserRootDir($user->getId());

        $children = $em->getRepository('CoreBundle:Directory')->findByParent($root->getId());

        $files = $em->getRepository('CoreBundle:File')
            ->getUserHomeFiles($root->getId());

        $userToken =  $this->get('session')->get('userToken');
        return $this->render('AppBundle:Home:index_user.html.twig', array(
                'directories'=>$this->getDirectoryFormat($children),
                'files'=>$this->getHomeFileFormat($files),
                'userTokent' => $userToken,
                'homedirId' => $root->getId())
        );
    }

    public function toDropzoneAction(){
        return $this->render('AppBundle:Home:dropzone.htlm.twig');
    }

    public function downloadFileAction(Request $request){

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




}