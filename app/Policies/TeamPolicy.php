<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Team $team): bool
    {
        return $user->belongsToTeam($team);
    }

    public function create(User $user): true
    {
        return true;
    }

    public function update(User $user, Team $team): bool
    {
        return $user->hasTeamRole($team, 'admin') ||
            $user->id === $team->creator_id;
    }

    public function delete(User $user, Team $team): bool
    {
        return $user->id === $team->creator_id;
    }
}
