<?php

declare(strict_types=1);

namespace App\Controller;

class fileController
{
    public $file;
    private $target_dir;
    private $target_file;


    public function __construct(array $file)
    {
        $this->file = $file;
    }

    public function getFile(): array
    {
        return $this->file;
    }

    public function getLocation(): string
    {
        return $this->target_file;
    }

    public function getFileType(): string
    {
        return strtolower(pathinfo($this->file['name'], PATHINFO_EXTENSION));
    }
    public function getFileName(): string
    {
        return strtolower($this->file['name']);
    }

    public function getFileSize(): int
    {
        return (int) (ceil(($this->file['size']) / 1024));
    }

    public function storeFile($id): void
    {
        $this->target_dir = "uploads/$id/";
        if (!is_dir($this->target_dir)) {
            mkdir($this->target_dir);
        }
        $this->target_file = $this->target_dir.basename($this->file['name']);
        move_uploaded_file($this->file["tmp_name"], $this->target_file);
    }
}