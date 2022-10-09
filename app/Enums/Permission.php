<?php

namespace App\Enums;
use Henzeb\Enumhancer\Concerns\From;

enum Permission
{
    use From;

    case ReadPermissions;

    case CreateUsers;
    case ReadUsers;
    case UpdateUsers;
    case DeleteUsers;

    case CreateLeagues;
    case ReadLeagues;
    case UpdateLeagues;
    case DeleteLeagues;

    case CreateTeams;
    case ReadTeams;
    case UpdateTeams;
    case DeleteTeams;

    case CreateMatches;
    case ReadMatches;
    case UpdateMatches;
    case DeleteMatches;
}
