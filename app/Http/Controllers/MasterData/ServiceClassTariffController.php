<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceClassTariff\ServiceClassTariffQuery;
use App\Http\Requests\ServiceClassTariff\ServiceClassTariffRequest;
use App\Http\Resources\ServiceClassTariff\ServiceClassTariffResource;
use App\Services\MasterData\ServiceClassTariffService;
use App\Utils\Http\APIResponse;

class ServiceClassTariffController extends Controller
{
    public function __construct(
        private ServiceClassTariffService $service
    ) {}

    public function find(ServiceClassTariffQuery $request)
    {
        $filters = $request->toFilter();
        $serviceClasses = $this->service->find($filters);
        $data = ServiceClassTariffResource::collection($serviceClasses->items);
        return APIResponse::withPagination($data, $serviceClasses, "successfully get service class tariffs");
    }

    public function findByID($id)
    {
        $serviceClass = $this->service->findByID($id);
        return APIResponse::success(
            new ServiceClassTariffResource($serviceClass),
            "successfully get service class tariff",
            200
        );
    }

    public function create(ServiceClassTariffRequest $request)
    {
        $schema = $request->toSchema();
        $this->service->create($schema);
        return APIResponse::success(
            null,
            "successfully created service class tariff",
            201
        );
    }

    public function update(ServiceClassTariffRequest $request, $id)
    {
        $schema = $request->toSchema();
        $this->service->update($id, $schema);
        return APIResponse::success(
            null,
            "successfully updated service class tariff",
            200
        );
    }

    public function delete($id)
    {
        $this->service->delete($id);
        return APIResponse::success(
            null,
            "successfully deleted service class tariff",
            200
        );
    }
}
