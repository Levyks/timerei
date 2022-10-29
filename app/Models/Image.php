<?php

namespace App\Models;

use App\Enums\ImageMimeType;
use App\Traits\LogUser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * App\Models\Image
 *
 * @property int $id
 * @property string $description
 * @property ImageVersion|null $original
 * @property Collection<ImageVersion> $versions
 * @mixin \Eloquent
 */
class Image extends Model
{
    use HasFactory, LogUser;

    protected $with = ['versions'];

    /**
     * Get the original version of this image.
     */
    protected function original(): Attribute
    {
        return Attribute::make(
            get: function() {
                foreach ($this->versions as $version) {
                    if ($version->is_original) return $version;
                }
                return null;
            }
        );
    }

    /**
     * Get the children of this image.
     */
    public function versions(): HasMany
    {
        return $this->hasMany(ImageVersion::class);
    }
}
