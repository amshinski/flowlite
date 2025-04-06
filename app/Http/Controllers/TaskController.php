<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Team $team)
    {
        $this->authorize('create', [Task::class, $team]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high'
        ]);

        $task = $team->tasks()->create(array_merge($validated, [
            'creator_id' => auth()->id()
        ]));

        return redirect()->route('tasks.show', $task);
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return Inertia::render('Tasks/Show', [
            'task' => $task->load(['comments.files', 'files', 'maintainers']),
            'statusHistory' => $task->statusChanges()->with('changer')->get()
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:planned,in_work,testing,finished',
            'priority' => 'nullable|in:low,medium,high',
            'maintainers' => 'sometimes|array'
        ]);

        $task->update($validated);

        if ($request->has('maintainers')) {
            $task->maintainers()->sync($request->maintainers);
        }

        return redirect()->back();
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return redirect()->back();
    }
}
