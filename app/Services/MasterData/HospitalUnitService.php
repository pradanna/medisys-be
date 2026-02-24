<?php

namespace App\Services\MasterData;

use App\DTOs\HospitalUnit\HospitalUnitQuerySchema;
use App\DTOs\HospitalUnit\HospitalUnitRequestSchema;
use App\Exceptions\DomainException;
use App\Interfaces\HospitalUnitInterface;
use App\Models\HospitalUnit;
use App\Utils\Pagination\PaginateResponse;

class HospitalUnitService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private HospitalUnitInterface $repository
    ) {}

    public function find(HospitalUnitQuerySchema $filters): PaginateResponse
    {
        return $this->repository->find($filters);
    }

    public function findByID(string $id): HospitalUnit
    {
        $hospitalUnit = $this->repository->findByID($id);
        if (!$hospitalUnit) {
            throw new DomainException("hospital unit not found", 404);
        }
        return $hospitalUnit;
    }

    public function create(HospitalUnitRequestSchema $schema): ?HospitalUnit
    {
        return $this->repository->create($schema);
    }

    public function update(string $id, HospitalUnitRequestSchema $schema): HospitalUnit
    {
        $hospitalUnit = $this->repository->findByID($id);
        if (!$hospitalUnit) {
            throw new DomainException("hospital unit not found", 404);
        }
        $hospitalUnit = $this->repository->update($id, $schema);
        return $hospitalUnit;
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }
}
