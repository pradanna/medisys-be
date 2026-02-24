<?php

namespace App\DTOs\HospitalUnit;

class HospitalUnitRequestSchema
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $code,
        public string $hospitalInstallationId,
        public string $name,
        public string $type,
        public bool $isActive
    ) {}
}
