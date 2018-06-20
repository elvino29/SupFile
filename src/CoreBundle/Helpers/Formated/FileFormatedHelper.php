<?php
/**
 * Created by PhpStorm.
 * User: KEVIN-PC
 * Date: 21/05/2018
 * Time: 22:11
 */

namespace CoreBundle\Helpers\Formated;


use CoreBundle\Entity\File;

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

    public function getHomeFileFormat(array $file){


        $formated = [];
        foreach ($file as $data){

            $formated[] = array(
                'id' => $data->getId(),
                'name' => $data->getName(),
                'path' => $data->getPath(),
                'updateAt' => $data->getUpdateAt(),
               'Parent' => $data->getDirectory()->getId(),
                'type' => $data->getType(),
            );
        }

        return $formated;
    }

    public function getHomeFileFrontFormat(array $file){

        $formated = [];
        foreach ($file as $data){

            $formated[] = array(
                'id' => $data->getId(),
                'name' => $data->getName(),
                'path' => $data->getPath(),
                'updateAt' => $data->getUpdateAt(),
                'type' => $data->getType(),
                'size' => $data->getSize(),
                'mimeType' => $data->getMineType(),
            );
        }

        return $formated;
    }
}