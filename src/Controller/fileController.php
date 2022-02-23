<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exceptions\AppException;

class fileController
{
    public $file;
    private $target_dir = "uploads/";
    private $target_file;


    public function __construct(array $file)
    {
        $this->file = $file;
        $this->target_file = $this->target_dir . basename($file["name"]);
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getLocation()
    {
        return $this->target_file;
    }

    public function getFileType() 
    {
        return strtolower(pathinfo($this->target_file,PATHINFO_EXTENSION));
    }

    public function getFileSize()
    {
        return (int) (($this->file['size'])/1024);
    }

    public function storeFile()
    {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $this->target_file)) {
          } else {
            throw new AppException('Błąd podczas zapisywania pliku');
          }
    }
}