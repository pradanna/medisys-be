<?php

namespace App\DTOs\ServiceClassTariff;

class ServiceClassTariffQuerySchema
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ?string $search,
        public ?string $serviceClassId,
        public int $page,
        public int $perPage,
        public string $sortBy,
        public string $order,
    ) {}
}
