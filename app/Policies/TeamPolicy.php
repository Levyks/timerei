<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\User;
use Faker\Provider\Base;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy extends BasePolicy
{
    protected static Permission $createPermission = Permission::CreateTeams;
    protected static Permission $readPermission = Permission::ReadTeams;
    protected static Permission $updatePermission = Permission::UpdateTeams;
    protected static Permission $deletePermission = Permission::DeleteTeams;
}
