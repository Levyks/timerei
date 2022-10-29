<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\City
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $name_with_state_abbr
 * @property string abbreviation
 * @property State $state
 * @mixin \Eloquent
 */
class City extends Model
{
    use HasFactory;

    protected $with = ['state'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the state of this city.
     */
    public function state(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Get the name of the city with the state abbreviation.
     */
    protected function nameWithStateAbbr(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->name . ' (' . $this->state->abbreviation . ')'
        );
    }
}
