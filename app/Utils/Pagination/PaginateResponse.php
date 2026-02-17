<?php

namespace App\Utils\Pagination;

use Illuminate\Support\Collection;

class PaginateResponse
{
    public function __construct(
        public Collection $items,
        public int $total,
        public int $perPage,
        public int $currentPage,
        public int $lastPage
    ) {}

    public static function fromLaravelPaginator(\Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator, Collection $entities): self
    {
        return new self(
            items: $entities,
            total: $paginator->total(),
            perPage: $paginator->perPage(),
            currentPage: $paginator->currentPage(),
            lastPage: $paginator->lastPage()
        );
    }
}
