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

        $team = $project->teams()->create(array_merge($validated, [
            'creator_id' => auth()->id()
        ]));

        return redirect()->route('teams.show', $team);
    }

    public function show(Team $team)
    {
        $this->authorize('view', $team);

        return Inertia::render('Teams/Show', [
            'team' => $team->load(['tasks', 'members', 'creator']),
            'tasks' => $team->tasks()
                ->with(['creator', 'maintainers'])
                ->paginate()
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

    public function destroy(Team $team)
    {
        $this->authorize('delete', $team);
        $team->delete();
        return redirect()->back();
    }
}
