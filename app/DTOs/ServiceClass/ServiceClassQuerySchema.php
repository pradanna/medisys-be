<?php

namespace App\DTOs\ServiceClass;

class ServiceClassQuerySchema
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ?string $search,
        public int $page,
        public int $perPage,
        public string $sortBy,
        public string $order,
    ) {}
}
