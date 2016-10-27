<?php
/**
 * Created by PhpStorm.
 * User: Czaro
 * Date: 2016-10-27
 * Time: 14:04
 */

namespace Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EntityRepository extends Controller
{
    public function addDefaultImage()
    {


        $fileName = md5(uniqid()).'.'. $file->guessExtension();
        $file->move(
            $this->getParameter('images_directory'),
            $fileName
        );
    }
}