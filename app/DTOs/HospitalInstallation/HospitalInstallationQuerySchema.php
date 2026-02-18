<?php

namespace App\DTOs\HospitalInstallation;

class HospitalInstallationQuerySchema
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ?string $search,
        public ?bool $isActive,
        public int $page,
        public int $perPage,
        public string $sortBy,
        public string $order,
    ) {}
}
