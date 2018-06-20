<?php
/**
 * Created by PhpStorm.
 * User: KEVIN-PC
 * Date: 04/04/2018
 * Time: 18:35
 */

namespace CoreBundle\Helpers\Formated;

trait DirectoryFormatedHelper {

    public function getDirectoryFormat(array $directory){


        $formated = [];
        foreach ($directory as $folder){
            $formated[] = array(
                'id' => $folder->getId(),
                'name' => $folder->getName(),
                'path' => $folder->getPath(),
                'updateAt' => $folder->getUpdateAt(),
                'Parent' => $folder->getParent()->getId(),
                'type' => 'directory'
            );
        }

        return $formated;
    }
}