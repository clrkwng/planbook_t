<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 9/8/2017
 * Time: 6:38 PM
 */

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;


class FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->getTargetDir(), $fileName);

        return $fileName;
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }

}