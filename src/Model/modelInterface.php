<?php
declare(strict_types=1);

namespace App\Model;

interface ModelInterface
{
    public function list(): array;

    public function get(int $id): array;
    
    public function add(array $articleData): void;
    
    public function edit(array $articleData): void;
    
    public function delete(int $id): void;
}