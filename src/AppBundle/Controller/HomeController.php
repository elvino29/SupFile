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

    public function toProfileAction(){
        return $this->render('AppBundle:Home:profile.html.twig');
    }



}