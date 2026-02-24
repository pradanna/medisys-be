<?php

namespace App\Repositories;

use App\DTOs\HospitalUnit\HospitalUnitQuerySchema;
use App\DTOs\HospitalUnit\HospitalUnitRequestSchema;
use App\Exceptions\DomainException;
use App\Interfaces\HospitalUnitInterface;
use App\Models\HospitalUnit;
use App\Utils\Pagination\PaginateResponse;

class HospitalUnitRepository implements HospitalUnitInterface
{
    public function find(HospitalUnitQuerySchema $filters): PaginateResponse
    {
        $data = HospitalUnit::with(['hospital_installation'])
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
            ->when(
                $filters->hospitalInstallationId,
                fn($q) =>
                $q->where('hospital_installation_id', $filters->hospitalInstallationId)
            )
            ->orderBy($filters->sortBy, $filters->order)
            ->paginate(
                perPage: $filters->perPage,
                page: $filters->page
            );
        return PaginateResponse::fromLaravelPaginator($data, collect($data->items()));
    }

    public function findByID(string $id): ?HospitalUnit
    {
        return HospitalUnit::with(['hospital_installation'])
            ->where('id', '=', $id)
            ->first();
    }

    public function create(HospitalUnitRequestSchema $schema): ?HospitalUnit
    {
        return HospitalUnit::create([
            'code' => $schema->code,
            'hospital_installation_id' => $schema->hospitalInstallationId,
            'name' => $schema->name,
            'is_active' => $schema->isActive,
        ]);
    }

    public function update(string $id, HospitalUnitRequestSchema $schema): ?HospitalUnit
    {
        $hospitalUnit = $this->findByID($id);
        if (!$hospitalUnit) {
            return null;
        }
        $hospitalUnit->update([
            'code' => $schema->code,
            'hospital_installation_id' => $schema->hospitalInstallationId,
            'name' => $schema->name,
            'is_active' => $schema->isActive,
        ]);
        return $hospitalUnit;
    }

    public function delete(string $id): void
    {
        $hospitalUnit = $this->findByID($id);
        if (!$hospitalUnit) {
            throw new DomainException("Hospital unit not found.", 404);
        }
        $hospitalUnit->delete();
    }
}
