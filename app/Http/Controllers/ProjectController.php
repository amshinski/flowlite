<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        return Inertia::render('Projects/Index', [
            'projects' => Project::where('creator_id', auth()->id())
                ->withCount('teams')
                ->paginate()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $project = Project::create($validated);

        return redirect()->route('projects.show', $project);
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);

        $project->load(['teams.members', 'creator']);

        $existingMemberIds = $project->teams->flatMap(function ($team) {
            return $team->members->pluck('id');
        })->unique()->values()->toArray();

        return Inertia::render('Projects/Show', [
            'project' => $project,
            'availableUsers' => User::whereNotIn('id', $existingMemberIds)->get()
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $project->update($validated);

        return redirect()->back();
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
        return redirect()->route('projects.index');
    }
}
