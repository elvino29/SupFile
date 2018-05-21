<?php
/**
 * Created by PhpStorm.
 * User: rakotomalala
 * Date: 14/05/2018
 * Time: 16:14
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{


    public function indexAction(){
      return $this->render('AppBundle:Home:index.html.twig');
    }

    public function toLoginAction(){
        return $this->render('AppBundle:Home:login.html.twig');
    }

    public function indexUserAction(){
        return $this->render('AppBundle:Home:index_user.html.twig');
    }

    public function toDropzoneAction(){
        return $this->render('AppBundle:Home:dropzone.htlm.twig');
    }


}