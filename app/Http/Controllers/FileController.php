<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class FileController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'file' => 'required|file|max:51200'
        ]);

        $path = $request->file('file')->store('task-files');

        $task->files()->create([
            'path' => $path,
            'name' => $request->file('file')->getClientOriginalName(),
            'uploaded_by' => auth()->id()
        ]);

        return redirect()->back();
    }

    public function destroy(File $file)
    {
        $this->authorize('delete', $file);
        $file->delete();
        return redirect()->back();
    }
}
