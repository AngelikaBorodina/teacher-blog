<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 10.02.19
 * Time: 13:50
 */

namespace AppBundle\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file, $dir)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->getTargetDirectory() . $dir, $fileName);

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

    public function remove($path , $dir){
        $fullPath = $this->targetDirectory . $dir . '/' . $path;
        if (file_exists($fullPath)){
            $fs = new Filesystem();
            $fs->remove($fullPath);
        }
    }
}