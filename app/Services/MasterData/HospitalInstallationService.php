<?php

namespace App\Services\MasterData;

use App\DTOs\HospitalInstallation\HospitalInstallationQuerySchema;
use App\DTOs\HospitalInstallation\HospitalInstallationRequestSchema;
use App\Interfaces\HospitalInstallationInterface;
use App\Models\HospitalInstallation;
use App\Utils\Pagination\PaginateResponse;

class HospitalInstallationService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private HospitalInstallationInterface $repository
    ) {}

    public function find(HospitalInstallationQuerySchema $filters): PaginateResponse
    {
        return $this->repository->find($filters);
    }

    public function findByID(string $id): ?HospitalInstallation
    {
        return $this->repository->findByID($id);
    }

    public function create(HospitalInstallationRequestSchema $schema): ?HospitalInstallation
    {
        return $this->repository->create($schema);
    }
}
