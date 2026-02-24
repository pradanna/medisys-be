<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\HospitalUnit\HospitalUnitQuery;
use App\Http\Requests\HospitalUnit\HospitalUnitRequest;
use App\Http\Resources\HospitalUnit\HospitalUnitResource;
use App\Services\MasterData\HospitalUnitService;
use App\Utils\Http\APIResponse;

class HospitalUnitController extends Controller
{
    public function __construct(
        private HospitalUnitService $service
    ) {}

    public function find(HospitalUnitQuery $request)
    {
        $filters = $request->toFilter();
        $hospitalUnits = $this->service->find($filters);
        $data = HospitalUnitResource::collection($hospitalUnits->items);
        return APIResponse::withPagination($data, $hospitalUnits, "successfully get hospital units");
    }

    public function findByID($id)
    {
        $hospitalUnit = $this->service->findByID($id);
        return APIResponse::success(
            new HospitalUnitResource($hospitalUnit),
            "successfully get hospital unit",
            200
        );
    }

    public function create(HospitalUnitRequest $request)
    {
        $schema = $request->toSchema();
        $this->service->create($schema);
        return APIResponse::success(
            null,
            "successfully created hospital unit",
            201
        );
    }

    public function update(HospitalUnitRequest $request, $id)
    {
        $schema = $request->toSchema();
        $this->service->update($id, $schema);
        return APIResponse::success(
            null,
            "successfully updated hospital unit",
            200
        );
    }

    public function delete($id)
    {
        $this->service->delete($id);
        return APIResponse::success(
            null,
            "successfully deleted hospital unit",
            200
        );
    }
}
