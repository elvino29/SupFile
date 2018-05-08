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
   /* public function indexAction(){

    }

    public function getAllFileAction(){

    }*/

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

        //vérifier si le fichier existe

        return new JsonResponse([

                    $request->get('name'),
                    $request->get('CreatedAt')
        ]);
    }

}