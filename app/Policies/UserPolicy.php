<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\User;
use Faker\Provider\Base;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy extends BasePolicy
{
    protected static Permission $createPermission = Permission::CreateUsers;
    protected static Permission $readPermission = Permission::ReadUsers;
    protected static Permission $updatePermission = Permission::UpdateUsers;
    protected static Permission $deletePermission = Permission::DeleteUsers;
}
