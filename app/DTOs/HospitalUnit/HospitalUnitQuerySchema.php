<?php

namespace App\DTOs\HospitalUnit;

class HospitalUnitQuerySchema
{
   /**
     * Create a new class instance.
     */
    public function __construct(
        public ?string $search,
        public ?string $hospitalInstallationId,
        public ?bool $isActive,
        public int $page,
        public int $perPage,
        public string $sortBy,
        public string $order,
    ) {}
}
