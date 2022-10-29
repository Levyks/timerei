<?php

namespace App\Models;
use App\Enums\ImageMimeType;
use App\Traits\LogUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ImageVersion
 *
 * @property int $id
 * @property int $image_id
 * @property Image $image
 * @property bool $is_original
 * @property string $path
 * @property ImageMimeType $mime_type
 * @property int $width
 * @property int $height
 * @mixin \Eloquent
 */
class ImageVersion extends Model
{
    use HasFactory, LogUser;

    protected $table = 'images_versions';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'mime_type' => ImageMimeType::class,
    ];

    /**
     * Get the parent image of this image.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

}
