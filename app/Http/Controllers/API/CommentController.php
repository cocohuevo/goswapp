<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $id)
{
    $this->validate($request, [
        'rating' => 'required|integer|between:1,5',
        'comment' => 'required|string',
    ]);

    $task = Task::findOrFail($id);
    $comment = new Comment();
    $comment->task_id = $task->id;
    $comment->user_id = $request->user()->id;
    $comment->rating = $request->input('rating');
    $comment->comment = $request->input('comment');
    $comment->save();

    return response()->json(['comment' => $comment]);
}
}
