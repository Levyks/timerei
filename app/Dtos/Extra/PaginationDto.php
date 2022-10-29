<?php

namespace App\Dtos\Extra;

use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\LaravelData\Data;

class PaginationDto extends Data
{
    public function __construct(
        public array $data,
        public int $page,
        public int $pageSize,
        public int $rowsPerPage,
        public int $totalElements,
        public int $totalPages,
        public bool $first,
        public bool $last,
        public bool $empty,
    ) {}


    /**
     * @param LengthAwarePaginator $paginator
     * @param callable $mapper
     * @return PaginationDto
     */
    public static function fromPaginator(LengthAwarePaginator $paginator, callable $mapper): PaginationDto
    {
        return new PaginationDto(
            data: $paginator->getCollection()->map($mapper)->toArray(),
            page: $paginator->currentPage(),
            pageSize: $paginator->getCollection()->count(),
            rowsPerPage: $paginator->perPage(),
            totalElements: $paginator->total(),
            totalPages: $paginator->lastPage(),
            first: $paginator->onFirstPage(),
            last: $paginator->lastPage() === $paginator->currentPage(),
            empty: $paginator->isEmpty(),
        );
    }
}
