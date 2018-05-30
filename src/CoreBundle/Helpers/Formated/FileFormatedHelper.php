<?php
/**
 * Created by PhpStorm.
 * User: KEVIN-PC
 * Date: 21/05/2018
 * Time: 22:11
 */

namespace CoreBundle\Helpers\Formated;


trait FileFormatedHelper {

    public function getFileFormat($file){

            $formated = array(
                'id' => $file->getId(),
                'name' => $file->getName(),
                'path' => $file->getPath(),
                'type' => $file->getType(),
                'createdAt' => $file->getCreatedAt(),
                'updateAt' => $file->getUpdateAt(),
                'token' => $file->getToken()
            );


        return $formated;
    }
}