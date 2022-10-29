<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\State
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $abbreviation
 * @mixin \Eloquent
 */
class State extends Model
{
    use HasFactory;

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
     * Get the cities of this state.
     */
    public function cities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(City::class);
    }
}
