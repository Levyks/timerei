<?php

namespace App\Dtos\Models\Team;

use App\Dtos\Models\City\BasicCityDto;
use App\Dtos\Models\Image\BasicImageDto;
use App\Models\Team;
use Spatie\LaravelData\Data;

class TeamDto extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $manager,
        public ?BasicImageDto $logo,
        public BasicCityDto $city,
        public ?string $location,
    ) {
    }

    public static function fromEntity(Team $team): self
    {
        return new self(
            id: $team->id,
            name: $team->name,
            manager: $team->manager,
            logo: $team->logo ? BasicImageDto::fromEntity($team->logo, $team->optimal_logo_version): null,
            city: BasicCityDto::fromEntity($team->city),
            location: $team->location,
        );
    }
}
