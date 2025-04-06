<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Comment;
use App\Models\File;
use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\TeamInvitation;
use App\Policies\CommentPolicy;
use App\Policies\FilePolicy;
use App\Policies\ProjectPolicy;
use App\Policies\TaskPolicy;
use App\Policies\TeamInvitationPolicy;
use App\Policies\TeamPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected array $policies = [
        Project::class => ProjectPolicy::class,
        Team::class => TeamPolicy::class,
        Task::class => TaskPolicy::class,
        Comment::class => CommentPolicy::class,
        File::class => FilePolicy::class,
        TeamInvitation::class => TeamInvitationPolicy::class,
    ];

    public function boot()
    {

    }
}
