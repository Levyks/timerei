<?php

namespace App\Dtos\Models\Team;

use App\Models\Team;
use Spatie\LaravelData\Data;

class BasicTeamDto extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $manager,
        public ?string $logo,
        public string $city,
        public ?string $location,
    ) {
    }

    public static function fromEntity(Team $team): self
    {
        return new self(
            id: $team->id,
            name: $team->name,
            manager: $team->manager,
            logo: $team->logo ? $team->optimal_logo_version->path : null,
            city: $team->city->name_with_state_abbr,
            location: $team->location,
        );
    }
}
