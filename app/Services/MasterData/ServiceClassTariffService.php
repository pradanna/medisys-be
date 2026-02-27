<?php

namespace App\Services\MasterData;

use App\DTOs\ServiceClassTariff\ServiceClassTariffQuerySchema;
use App\DTOs\ServiceClassTariff\ServiceClassTariffRequestSchema;
use App\Exceptions\DomainException;
use App\Interfaces\ServiceClassTariffInterface;
use App\Models\ServiceClassTariff;
use App\Utils\Pagination\PaginateResponse;

class ServiceClassTariffService
{
    public function __construct(
        private ServiceClassTariffInterface $repository
    ) {}

    public function find(ServiceClassTariffQuerySchema $filters): PaginateResponse
    {
        return $this->repository->find($filters);
    }

    public function findByID(string $id): ServiceClassTariff
    {
        $serviceClassTariff = $this->repository->findByID($id);
        if (!$serviceClassTariff) {
            throw new DomainException("service class tariff not found", 404);
        }
        return $serviceClassTariff;
    }

    public function create(ServiceClassTariffRequestSchema $schema): ?ServiceClassTariff
    {
        return $this->repository->create($schema);
    }

    public function update(string $id, ServiceClassTariffRequestSchema $schema): ServiceClassTariff
    {
        $serviceClassTariff = $this->repository->findByID($id);
        if (!$serviceClassTariff) {
            throw new DomainException("service class tariff not found", 404);
        }
        $serviceClassTariff = $this->repository->update($id, $schema);
        return $serviceClassTariff;
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }
}
