<?php

namespace App\Repositories;

use App\DTOs\ServiceClass\ServiceClassQuerySchema;
use App\DTOs\ServiceClass\ServiceClassRequestSchema;
use App\Exceptions\DomainException;
use App\Interfaces\ServiceClassInterface;
use App\Models\ServiceClass;
use App\Utils\Pagination\PaginateResponse;
use Illuminate\Support\Facades\DB;

class ServiceClassRepository implements ServiceClassInterface
{
    public function find(ServiceClassQuerySchema $filters): PaginateResponse
    {
        $data = ServiceClass::with([])
            ->when(
                $filters->search,
                fn($q, $term) => $q->where(
                    fn($sub) =>
                    $sub->where('code', 'LIKE', "%{$term}%")
                        ->orWhere('name', 'LIKE', "%{$term}%")
                        ->orWhere('bpjs_class_code', 'LIKE', "%{$term}%")
                )
            )
            ->orderBy($filters->sortBy, $filters->order)
            ->paginate(
                perPage: $filters->perPage,
                page: $filters->page
            );
        return PaginateResponse::fromLaravelPaginator($data, collect($data->items()));
    }

    public function findByID(string $id): ?ServiceClass
    {
        return ServiceClass::with([])
            ->where('id', '=', $id)
            ->first();
    }

    public function create(ServiceClassRequestSchema $schema): ?ServiceClass
    {
        return ServiceClass::create([
            'code' => $schema->code,
            'name' => $schema->name,
            'bpjs_class_code' => $schema->bpjsClassCode,
        ]);
    }

    public function update(string $id, ServiceClassRequestSchema $schema): ?ServiceClass
    {
        $serviceClass = $this->findByID($id);
        if (!$serviceClass) {
            return null;
        }
        $serviceClass->update([
            'code' => $schema->code,
            'name' => $schema->name,
            'bpjs_class_code' => $schema->bpjsClassCode,
        ]);
        return $serviceClass;
    }

    public function delete(string $id): void
    {
        if (DB::transactionLevel() === 0) {
            throw new DomainException("Repository Error: Delete operation must be wrapped in a database transaction.");
        }
        $serviceClass = $this->findByID($id);
        if (!$serviceClass) {
            throw new DomainException("service class not found.", 404);
        }
        $serviceClass->update([
            'code' => null
        ]);
        $serviceClass->delete();
    }
}
