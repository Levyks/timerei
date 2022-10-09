<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\User;
use Faker\Provider\Base;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BasePolicy
{
    use HandlesAuthorization;

    protected static Permission $createPermission;
    protected static Permission $readPermission;
    protected static Permission $updatePermission;
    protected static Permission $deletePermission;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->hasPermission(static::$readPermission);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model): Response|bool
    {
        return $user->hasPermission(static::$readPermission);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user): Response|bool
    {
        var_dump(static::$createPermission);
        var_dump($user);
        return $user->hasPermission(static::$createPermission);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model): Response|bool
    {
        return $user->hasPermission(static::$updatePermission);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model): Response|bool
    {
        return $user->hasPermission(static::$deletePermission);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $model): Response|bool
    {
        return $user->hasPermissions(static::$createPermission, static::$updatePermission);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $model): Response|bool
    {
        return $user->hasPermissions(static::$deletePermission);
    }
}
