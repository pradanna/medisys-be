<?php

namespace App\Interfaces;

use App\DTOs\HospitalInstallation\HospitalInstallationQuerySchema;
use App\DTOs\HospitalInstallation\HospitalInstallationRequestSchema;
use App\Models\HospitalInstallation;
use App\Utils\Pagination\PaginateResponse;

interface HospitalInstallationInterface
{
    public function find(HospitalInstallationQuerySchema $filters): PaginateResponse;
    public function findByID(string $id): ?HospitalInstallation;
    public function create(HospitalInstallationRequestSchema $schema): ?HospitalInstallation;
}
