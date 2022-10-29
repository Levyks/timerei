<?php

namespace App\Dtos\Models\Image;

use App\Enums\ImageMimeType;
use App\Models\ImageVersion;
use Spatie\LaravelData\Data;

class ImageVersionDto extends Data
{
    public function __construct(
        public int $id,
        public string $path,
        public ImageMimeType $mime_type,
        public int $width,
        public int $height,
        public bool $is_original,
    ){}

    public static function fromEntity(ImageVersion $imageVersion): self
    {
        return new self(
            id: $imageVersion->id,
            path: $imageVersion->path,
            mime_type: $imageVersion->mime_type,
            width: $imageVersion->width,
            height: $imageVersion->height,
            is_original: $imageVersion->is_original,
        );
    }

}
