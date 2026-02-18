<?php

namespace App\Services\MasterData;

use App\DTOs\HospitalInstallation\HospitalInstallationQuerySchema;
use App\DTOs\HospitalInstallation\HospitalInstallationRequestSchema;
use App\Exceptions\DomainException;
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

    public function findByID(string $id): HospitalInstallation
    {
        $hospitalInstallation = $this->repository->findByID($id);
        if (!$hospitalInstallation) {
            throw new DomainException("hospital installation not found", 404);
        }
        return $hospitalInstallation;
    }

    public function create(HospitalInstallationRequestSchema $schema): ?HospitalInstallation
    {
        return $this->repository->create($schema);
    }

    public function update(string $id, HospitalInstallationRequestSchema $schema): HospitalInstallation
    {
        $this->findByID($id);
        $hospitalInstallation = $this->repository->update($id, $schema);
        return $hospitalInstallation;
    }
}
