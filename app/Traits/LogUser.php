<?php

namespace App\Traits;

use Eloquent;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property \App\Models\User $created_by
 * @property \App\Models\User $updated_by
 * @mixin Eloquent
 */
trait LogUser
{
    /**
     * Get the user that created the model.
     */
    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that updated the model.
     */
    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->created_by_id = auth()->id();
            $model->updated_by_id = auth()->id();
        });

        static::updating(function ($model) {
            $model->updated_by_id = auth()->id();
        });
    }
}
