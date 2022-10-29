<?php

namespace App\Dtos\Models\Team;

use App\Models\City;
use App\Models\Image;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;

class CreateOrUpdateTeamDto extends Data
{
    public function __construct(
        #[StringType(), Max(255)]
        public string $name,
        #[StringType(), Max(255)]
        public string $manager,
        #[Nullable, Exists(Image::class, 'id')]
        public ?int $logo_id,
        #[Required, Exists(City::class, 'id')]
        public int $city_id,
        #[Nullable, StringType(), Max(255)]
        public ?string $location,
    ) {
    }
}
