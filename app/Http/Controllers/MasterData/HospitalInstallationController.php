<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\HospitalInstallation\HospitalInstallationQuery;
use App\Http\Requests\HospitalInstallation\HospitalInstallationRequest;
use App\Http\Resources\HospitalInstallation\HospitalInstallationResource;
use App\Services\MasterData\HospitalInstallationService;
use App\Utils\Http\APIResponse;

class HospitalInstallationController extends Controller
{
    public function __construct(
        private HospitalInstallationService $service
    ) {}

    public function find(HospitalInstallationQuery $request)
    {
        $filters = $request->toFilter();
        $hospitalInstallations = $this->service->find($filters);
        $data = HospitalInstallationResource::collection($hospitalInstallations->items);
        return APIResponse::withPagination($data, $hospitalInstallations, "successfully get hospital installations");
    }

    public function findByID($id)
    {
        $hospitalInstallation = $this->service->findByID($id);
        return APIResponse::success(
            new HospitalInstallationResource($hospitalInstallation),
            "successfully get hospital installation",
            200
        );
    }

    public function create(HospitalInstallationRequest $request)
    {
        $schema = $request->toSchema();
        $hospitalInstallation = $this->service->create($schema);
        return APIResponse::success(
            [
                'id' => $hospitalInstallation->id,
            ],
            "successfully created hospital installation",
            201
        );
    }

    public function update(HospitalInstallationRequest $request, $id)
    {
        $schema = $request->toSchema();
        $this->service->update($id, $schema);
        return APIResponse::success(
            null,
            "successfully updated hospital installation",
            200
        );
    }

    public function delete($id)
    {
        $this->service->delete($id);
        return APIResponse::success(
            null,
            "successfully deleted hospital installation",
            200
        );
    }
}
