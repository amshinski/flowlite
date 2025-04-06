<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Task $task)
    {
        $this->authorize('view', $task);

        $validated = $request->validate([
            'body' => 'required|string'
        ]);

        $task->comments()->create([
            'body' => $validated['body'],
            'user_id' => auth()->id()
        ]);

        return redirect()->back();
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        $comment->update($request->validate(['body' => 'required|string']));
        return redirect()->back();
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return redirect()->back();
    }
}
