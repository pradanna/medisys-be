<?php

namespace App\Repositories;

use App\DTOs\HospitalInstallation\HospitalInstallationQuerySchema;
use App\DTOs\HospitalInstallation\HospitalInstallationRequestSchema;
use App\Interfaces\HospitalInstallationInterface;
use App\Models\HospitalInstallation;
use App\Utils\Pagination\PaginateResponse;

class HospitalInstallationRepository implements HospitalInstallationInterface
{
    public function find(HospitalInstallationQuerySchema $filters): PaginateResponse
    {
        $data = HospitalInstallation::with([])
            ->when(
                $filters->search,
                fn($q, $term) => $q->where(
                    fn($sub) =>
                    $sub->where('code', 'LIKE', "%{$term}%")
                        ->orWhere('name', 'LIKE', "%{$term}%")
                )
            )
            ->when(
                $filters->isActive !== null,
                fn($q) =>
                $q->where('is_active', $filters->isActive)
            )
            ->orderBy($filters->sortBy, $filters->order)
            ->paginate(
                perPage: $filters->perPage,
                page: $filters->page
            );
        return PaginateResponse::fromLaravelPaginator($data, collect($data->items()));
    }

    public function findByID(string $id): ?HospitalInstallation
    {
        return HospitalInstallation::with([])
            ->where('id', '=', $id)
            ->first();
    }

    public function create(HospitalInstallationRequestSchema $schema): ?HospitalInstallation
    {
        throw new \Exception('Not implemented');
    }
}
