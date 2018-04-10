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
                'id' => $folder->getDirectories()->getId(),
                'name' => $folder->getDirectories()->getName(),
                'path' => $folder->getDirectories()->getPath(),
                'updateAt' => $folder->getDirectories()->getUpdateAt(),
                'user' => $folder->getUsername()
            );
        }

        return $formated;
    }
}