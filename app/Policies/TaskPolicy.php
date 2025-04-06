<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\Team;
use App\Models\User;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Task $task): bool
    {
        return $user->belongsToTeam($task->team);
    }

    public function create(User $user, Team $team): bool
    {
        return $user->belongsToTeam($team);
    }

    public function update(User $user, Task $task): bool
    {
        return $user->belongsToTeam($task->team) && (
                $user->hasTeamRole($task->team, 'maintainer') ||
                $task->maintainers->contains($user->id) ||
                $user->id === $task->creator_id
            );
    }

    public function delete(User $user, Task $task)
    {
        return $user->id === $task->creator_id;
    }
}
