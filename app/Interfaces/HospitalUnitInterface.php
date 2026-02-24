<?php

namespace App\Interfaces;

use App\DTOs\HospitalUnit\HospitalUnitQuerySchema;
use App\DTOs\HospitalUnit\HospitalUnitRequestSchema;
use App\Models\HospitalUnit;
use App\Utils\Pagination\PaginateResponse;

interface HospitalUnitInterface
{
    public function find(HospitalUnitQuerySchema $filters): PaginateResponse;
    public function findByID(string $id): ?HospitalUnit;
    public function create(HospitalUnitRequestSchema $schema): ?HospitalUnit;
    public function update(string $id, HospitalUnitRequestSchema $schema): ?HospitalUnit;
    public function delete(string $id): void;
}
