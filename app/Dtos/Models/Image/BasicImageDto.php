<?php

namespace App\Dtos\Models\Image;

use App\Models\Image;
use App\Models\ImageVersion;
use Spatie\LaravelData\Data;

class BasicImageDto extends Data
{
    public function __construct(
        public int $id,
        public string $description,
        public string $path,
    )
    {
    }

    public static function fromEntity(Image $image, ?ImageVersion $version): self
    {
        $version = $version ?? $image->original;
        return new self(
            id: $image->id,
            description: $image->description,
            path: $version->path,
        );
    }

}
