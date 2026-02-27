<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceClass\ServiceClassQuery;
use App\Http\Requests\ServiceClass\ServiceClassRequest;
use App\Http\Resources\ServiceClass\ServiceClassResource;
use App\Services\MasterData\ServiceClassService;
use App\Utils\Http\APIResponse;

class ServiceClassController extends Controller
{
    public function __construct(
        private ServiceClassService $service
    ) {}

    public function find(ServiceClassQuery $request)
    {
        $filters = $request->toFilter();
        $serviceClasses = $this->service->find($filters);
        $data = ServiceClassResource::collection($serviceClasses->items);
        return APIResponse::withPagination($data, $serviceClasses, "successfully get service classes");
    }

    public function findByID($id)
    {
        $serviceClass = $this->service->findByID($id);
        return APIResponse::success(
            new ServiceClassResource($serviceClass),
            "successfully get service class",
            200
        );
    }

    public function create(ServiceClassRequest $request)
    {
        $schema = $request->toSchema();
        $this->service->create($schema);
        return APIResponse::success(
            null,
            "successfully created service class",
            201
        );
    }

    public function update(ServiceClassRequest $request, $id)
    {
        $schema = $request->toSchema();
        $this->service->update($id, $schema);
        return APIResponse::success(
            null,
            "successfully updated service class",
            200
        );
    }

    public function delete($id)
    {
        $this->service->delete($id);
        return APIResponse::success(
            null,
            "successfully deleted service class",
            200
        );
    }
}
