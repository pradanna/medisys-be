<?php

namespace App\Interfaces;

use App\DTOs\ServiceClassTariff\ServiceClassTariffQuerySchema;
use App\DTOs\ServiceClassTariff\ServiceClassTariffRequestSchema;
use App\Models\ServiceClassTariff;
use App\Utils\Pagination\PaginateResponse;

interface ServiceClassTariffInterface
{
    public function find(ServiceClassTariffQuerySchema $filters): PaginateResponse;
    public function findByID(string $id): ?ServiceClassTariff;
    public function create(ServiceClassTariffRequestSchema $schema): ?ServiceClassTariff;
    public function update(string $id, ServiceClassTariffRequestSchema $schema): ?ServiceClassTariff;
    public function delete(string $id): void;
}
