<?php

namespace App\Dtos\Models\City;

use App\Models\City;
use Spatie\LaravelData\Data;

class BasicCityDto extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $state,
    ) {
    }

    public static function fromEntity(City $city): self
    {
        return new self(
            id: $city->id,
            name: $city->name,
            state: $city->state->abbreviation,
        );
    }
}
