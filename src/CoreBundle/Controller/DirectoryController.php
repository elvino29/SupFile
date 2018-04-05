<?php
/**
 * Created by PhpStorm.
 * User: KEVIN-PC
 * Date: 19/03/2018
 * Time: 17:41
 */

namespace CoreBundle\Controller;


use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DirectoryController extends Controller
{

    use \CoreBundle\Helpers\Formated\DirectoryFormatedHelper;
    /**
     * @Rest\Get("/folder/user/{id}")
     * requirements={"id" = "\d+"}
     *
     * @param $id
     * @return JsonResponse
     */
    public function getUserFolderAction($id){

        $em = $this->getDoctrine()
            ->getManager();

        $folders = $em->getRepository('CoreBundle:Directory')
                     ->getUserFolder($id);

        //dump($folder);


        return new JsonResponse($this->getDirectoryFormat($folders));
    }

}