<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BasePolicy
{
    use HandlesAuthorization;

    protected static Permission $createPermission;
    protected static Permission $readPermission;
    protected static Permission $updatePermission;
    protected static Permission $deletePermission;

    protected function getPermissionsMissingString(array $permissions): string
    {
        return implode(', ', array_map(fn(Permission $p) => $p->name, $permissions));
    }

    protected function check(User $user, array $requiredPermissions): Response
    {
        $missing = $user->permissionsMissing(...$requiredPermissions);

        if (count($missing) === 0)
            return Response::allow();

        /**
         * It's a bit janky to pass the missing permissions back as a string
         * in the `message` attribute, but it's the only way to pass data back,
         * and since we'll intercept this exception anyway, we can just parse it back into an array.
         */
        return Response::deny($this->getPermissionsMissingString($missing));
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function viewAny(User $user): Response
    {
        return $this->check($user, [static::$readPermission]);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function view(User $user): Response
    {
        return $this->check($user, [static::$readPermission]);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function create(User $user): Response
    {
        return $this->check($user, [static::$createPermission]);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function update(User $user): Response
    {
        return $this->check($user, [static::$updatePermission]);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response
     */
    public function delete(User $user): Response
    {
        return $this->check($user, [static::$deletePermission]);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function restore(User $user): Response
    {
        return $this->check($user, [static::$createPermission, static::$updatePermission]);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function forceDelete(User $user): Response
    {
        return $this->check($user, [static::$deletePermission]);
    }
}
