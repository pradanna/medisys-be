<?php

namespace App\DTOs\ServiceClassTariff;

class ServiceClassTariffRequestSchema
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $serviceClassId,
        public string $payerType,
        public float $dailyRate,
    ) {}
}
