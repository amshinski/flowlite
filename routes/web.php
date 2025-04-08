<?php

use App\Models\Project;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/telegram/auth/callback', [\App\Http\Controllers\AuthController::class, 'handleTelegramCallback'])
    ->name('telegram.auth.callback');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard', [
            'projects' => auth()->check() ?
                Project::with(['teams' => fn($q) => $q->withCount('members')])
                    ->withCount('teams')
                    ->where('creator_id', auth()->id())
                    ->get()
                : [],
        ]);
    })->name('dashboard');

    Route::resource('projects', \App\Http\Controllers\ProjectController::class);

    Route::prefix('projects/{project}')->group(function () {
        Route::resource('teams', \App\Http\Controllers\TeamController::class)
            ->names([
                'store' => 'projects.teams.store',
                'show' => 'projects.teams.show',
                'update' => 'projects.teams.update',
                'destroy' => 'projects.teams.destroy',
            ]);
    });
});
