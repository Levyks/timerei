<?php

namespace App\Models;

use App\Enums\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PermissionUser
 *
 * @property int $id
 * @property \App\Models\User $user
 * @property int $user_id
 * @property \App\Enums\Permission $permission
 * @method static \Database\Factories\PermissionUserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUser wherePermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUser whereUserId($value)
 * @mixin \Eloquent
 */
class PermissionUser extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'permission',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'permission' => Permission::class,
    ];

    /**
     * Get the user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
