<?php

namespace App\DTOs\ServiceClass;

class ServiceClassRequestSchema
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $code,
        public string $name,
        public ?string $bpjsClassCode,
    ) {}
}
