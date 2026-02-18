<?php

namespace App\DTOs\HospitalInstallation;

class HospitalInstallationRequestSchema
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $code,
        public string $name,
        public bool $isActive
    ) {}
}
