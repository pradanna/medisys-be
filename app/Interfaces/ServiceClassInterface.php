<?php

namespace App\Interfaces;

use App\DTOs\ServiceClass\ServiceClassQuerySchema;
use App\DTOs\ServiceClass\ServiceClassRequestSchema;
use App\Models\ServiceClass;
use App\Utils\Pagination\PaginateResponse;

interface ServiceClassInterface
{
    public function find(ServiceClassQuerySchema $filters): PaginateResponse;
    public function findByID(string $id): ?ServiceClass;
    public function create(ServiceClassRequestSchema $schema): ?ServiceClass;
    public function update(string $id, ServiceClassRequestSchema $schema): ?ServiceClass;
    public function delete(string $id): void;
}
