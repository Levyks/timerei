<?php

namespace App\Models;

use App\Traits\LogUser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Team
 *
 * @property int $id
 * @property string $name
 * @property User $manager
 * @property int $logo_id
 * @property Image $logo
 * @property ImageVersion $optimal_logo_version
 * @property int $city_id
 * @property City $city
 * @property string $location
 * @mixin \Eloquent
 */
class Team extends Model
{
    use HasFactory, LogUser;

    protected $with = ['city'];

    /**
     * Get the city of this team.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the logo of this team.
     */
    public function logo(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * Get the original image of this image.
     */
    protected function optimalLogoVersion(): Attribute
    {
        return Attribute::make(
            get: function() {
                if(!$this->logo) return null;
                foreach ($this->logo->versions as $version) {
                    if ($version->width === 512 && $version->height === 512)
                        return $version;
                }
                return $this->logo->original;
            }
        );
    }

}
