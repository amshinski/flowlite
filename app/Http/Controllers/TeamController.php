<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeamController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $project->teams()->create($validated);

        return redirect()->route('projects.show', $project);
    }

    public function show(Project $project, Team $team, $status = null)
    {
        $this->authorize('view', $team);

        if ($status === null) $status = 'planned';

        $tasks = $team->tasks()
            ->when($status, fn($q) => $q->where('status', $status))
            ->with(['creator', 'maintainers'])
            ->get();

        $statuses = [
            'planned' => 'Planned',
            'in_work' => 'In Work',
            'testing' => 'Testing',
            'finished' => 'Finished'
        ];

        unset($statuses[$status]);

        return Inertia::render('Teams/Show', [
            'project' => $project,
            'team' => $team->load(['members', 'creator']),
            'tasks' => $tasks,
            'status' => $status,
            'statuses' => $statuses,
        ]);
    }

    public function update(Request $request, Team $team)
    {
        $this->authorize('update', $team);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255'
        ]);

        $team->update($validated);
        return redirect()->back();
    }

    public function destroy(Project $project, Team $team)
    {
        $this->authorize('delete', $team);
        $team->delete();
        return redirect()->back();
    }
}
