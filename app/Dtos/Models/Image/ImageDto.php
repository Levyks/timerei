<?php

namespace App\Dtos\Models\Image;

use App\Models\Image;
use App\Models\ImageVersion;
use Spatie\LaravelData\Data;

class ImageDto extends Data
{
    public function __construct(
        public int $id,
        public string $description,
        public array $versions,
    ){}

    public static function fromEntity(Image $image): self
    {
        return new self(
            id: $image->id,
            description: $image->description,
            versions: $image->versions->map(fn(ImageVersion $version) => ImageVersionDto::fromEntity($version))->toArray(),
        );
    }
}
