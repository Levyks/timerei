<?php

namespace App\Dtos\Extra;

use Spatie\LaravelData\Attributes\Validation\Between;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Data;

class PageableDto extends Data
{
    public function __construct(
        #[Nullable, IntegerType, Min(1)]
        public int $page = 1,
        #[Nullable, IntegerType, Between(1, 100)]
        public int $rowsPerPage = 10,
    ) {
    }

    public static function default(): PageableDto
    {
        return new PageableDto();
    }
}
