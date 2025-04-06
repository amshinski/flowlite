<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\TeamInvitation;
use App\Models\User;

class TeamInvitationPolicy
{
    public function create(User $user, Team $team): bool
    {
        return $user->hasTeamRole($team, 'admin');
    }

    public function delete(User $user, TeamInvitation $invitation): bool
    {
        return $user->hasTeamRole($invitation->team, 'admin');
    }
}
