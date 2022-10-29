<?php

namespace App\Models;

use App\Traits\LogUser;
use App\Enums\Permission;
use DateTime;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property DateTime $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property PermissionUser $permissions
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LogUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The permissions that this user has.
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(PermissionUser::class);
    }

    public function hasPermission(Permission $permission): bool
    {
        foreach ($this->permissions as $user_permission) {
            if ($user_permission->permission === $permission) return true;
        }
        return false;
    }

    public function hasPermissions(Permission ...$permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) return false;
        }
        return true;
    }

    public function permissionsMissing(Permission ...$permissions): array
    {
        $missing = [];
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) $missing[] = $permission;
        }
        return $missing;
    }

    /**
     * @param Permission[] $permissions
     * @return void
     */
    public function addPermissions(array $permissions): void
    {
        $permissions = array_filter($permissions, fn ($p) => !$this->hasPermission($p));
        $permission_user_array = array_map(fn($p) => new PermissionUser(['permission' => $p]), $permissions);
        $this->permissions()->saveMany($permission_user_array);
    }
}
