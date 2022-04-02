<?php
declare(strict_types=1);

namespace App\Model;

interface ModelInterface
{
    public function list(int $pageNumber, int $pageSize, ?array $sortParams): array;

    public function get(int $id): array;
    
    public function add(array $taskData): string;
    
    public function edit(array $taskData): void;
    
    public function delete(int $id): void;
}