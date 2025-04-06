<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Project $project): bool
    {
        return $user->belongsToTeam($project->team);
    }

    public function create(User $user): true
    {
        return true;
    }

    public function update(User $user, Project $project): bool
    {
        return $user->id === $project->creator_id;
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->id === $project->creator_id;
    }
}
