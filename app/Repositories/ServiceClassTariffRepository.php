<?php

namespace App\Repositories;

use App\DTOs\ServiceClassTariff\ServiceClassTariffQuerySchema;
use App\DTOs\ServiceClassTariff\ServiceClassTariffRequestSchema;
use App\Exceptions\DomainException;
use App\Interfaces\ServiceClassTariffInterface;
use App\Models\ServiceClassTariff;
use App\Utils\Pagination\PaginateResponse;

class ServiceClassTariffRepository implements ServiceClassTariffInterface
{
    public function find(ServiceClassTariffQuerySchema $filters): PaginateResponse
    {
        $data = ServiceClassTariff::with(['service_class'])
            ->when(
                $filters->serviceClassId,
                fn($q) =>
                $q->where('service_class_id', $filters->serviceClassId)
            )
            ->orderBy($filters->sortBy, $filters->order)
            ->paginate(
                perPage: $filters->perPage,
                page: $filters->page
            );
        return PaginateResponse::fromLaravelPaginator($data, collect($data->items()));
    }

    public function findByID(string $id): ?ServiceClassTariff
    {
        return ServiceClassTariff::with(['service_class'])
            ->where('id', '=', $id)
            ->first();
    }

    public function create(ServiceClassTariffRequestSchema $schema): ?ServiceClassTariff
    {
        return ServiceClassTariff::create([
            'payer_type' => $schema->payerType,
            'service_class_id' => $schema->serviceClassId,
            'daily_rate' => $schema->dailyRate,
        ]);
    }

    public function update(string $id, ServiceClassTariffRequestSchema $schema): ?ServiceClassTariff
    {
        $serviceClassTariff = $this->findByID($id);
        if (!$serviceClassTariff) {
            return null;
        }
        $serviceClassTariff->update([
            'payer_type' => $schema->payerType,
            'service_class_id' => $schema->serviceClassId,
            'daily_rate' => $schema->dailyRate,
        ]);
        return $serviceClassTariff;
    }

    public function delete(string $id): void
    {
        $serviceClassTariff = $this->findByID($id);
        if (!$serviceClassTariff) {
            throw new DomainException("service class tariff not found.", 404);
        }
        $serviceClassTariff->delete();
    }
}
