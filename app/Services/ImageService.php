<?php

namespace App\Services;

use Exception;
use App\Dtos\Models\Image\CreateImageDto;
use App\Enums\ImageMimeType;
use App\Models\Image;
use App\Models\ImageVersion;
use Illuminate\Support\Facades\Event;
use Mimey\MimeTypes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Illuminate\Database\Events\TransactionRolledBack;

class ImageService
{
    public function __construct(public ImageManager $imageManager)
    {
    }

    public function generatePath(ImageMimeType $mimeType): string
    {
        $mimes = new MimeTypes();
        $extension = $mimes->getExtension($mimeType->value);
        return 'public/images/'.Str::uuid().'.'.$extension;
    }

    public function createVersion(Image $imageEntity, string $originalPath, ?int $width, ?int $height, ImageMimeType $mimeType = ImageMimeType::Webp, bool $isOriginal = false): ImageVersion
    {
        $image = $this->imageManager->make($originalPath);

        if($width && $height) {
            $image->fit($width, $height);
        }

        $image->encode($mimeType->value);

        $path = $this->generatePath($mimeType);
        Storage::put($path, $image);

        Event::listen(TransactionRolledBack::class, function () use ($path) {
            Storage::delete($path);
        });

        $version = new ImageVersion();
        $version->image_id = $imageEntity->id;
        $version->is_original = $isOriginal;
        $version->path = $path;
        $version->mime_type = $image->mime();
        $version->width = $image->width();
        $version->height = $image->height();
        $version->save();

        return $version;
    }

    public function createVersionIfDoesntExist(Image $imageEntity, ?int $width, ?int $height, ImageMimeType $mimeType = ImageMimeType::Webp): ImageVersion
    {
        // More efficient than doing a query, since we're eager loading all versions already
        foreach ($imageEntity->versions as $version) {
            if ($version->width === $width && $version->height === $height && $version->mime_type === $mimeType) {
                return $version;
            }
        }

        return $this->createVersion($imageEntity, Storage::path($imageEntity->original->path), $width, $height, $mimeType);
    }

    public function createVersionIfDoesntExistFromId(int $id, ?int $width, ?int $height, ImageMimeType $mimeType = ImageMimeType::Webp): ImageVersion
    {
        $image = Image::findOrFail($id);
        return $this->createVersionIfDoesntExist($image, $width, $height, $mimeType);
    }

    public function create(CreateImageDto $dto, ImageMimeType $mimeType = ImageMimeType::Webp): Image
    {
        $image = new Image();
        $image->description = $dto->description;
        $image->save();

        $this->createVersion($image, $dto->image->getRealPath(), null, null, $mimeType, true);

        return $image;
    }


}
