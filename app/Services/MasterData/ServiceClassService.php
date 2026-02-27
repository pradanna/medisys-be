<?php

namespace App\Services\MasterData;

use App\DTOs\ServiceClass\ServiceClassQuerySchema;
use App\DTOs\ServiceClass\ServiceClassRequestSchema;
use App\Exceptions\DomainException;
use App\Interfaces\ServiceClassInterface;
use App\Models\ServiceClass;
use App\Utils\Pagination\PaginateResponse;
use Illuminate\Support\Facades\DB;

class ServiceClassService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private ServiceClassInterface $repository
    ) {}

    public function find(ServiceClassQuerySchema $filters): PaginateResponse
    {
        return $this->repository->find($filters);
    }

    public function findByID(string $id): ServiceClass
    {
        $serviceClass = $this->repository->findByID($id);
        if (!$serviceClass) {
            throw new DomainException("service class not found", 404);
        }
        return $serviceClass;
    }

    public function create(ServiceClassRequestSchema $schema): ?ServiceClass
    {
        return $this->repository->create($schema);
    }

    public function update(string $id, ServiceClassRequestSchema $schema): ServiceClass
    {
        $serviceClass = $this->repository->findByID($id);
        if (!$serviceClass) {
            throw new DomainException("service class not found", 404);
        }
        $serviceClass = $this->repository->update($id, $schema);
        return $serviceClass;
    }

    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            $this->repository->delete($id);
        });
    }
}
