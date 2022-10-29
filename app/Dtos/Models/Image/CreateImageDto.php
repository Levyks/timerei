<?php

namespace App\Dtos\Models\Image;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\Image;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class CreateImageDto extends Data
{
    public function __construct(
        #[StringType, Max(255)]
        public string $description,
        #[Required, Image, Max(16384)]
        public UploadedFile $image
    ){}
}
