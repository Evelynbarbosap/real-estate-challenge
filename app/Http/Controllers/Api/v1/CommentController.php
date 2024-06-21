<?php

namespace App\Http\Controllers\Api\v1;


use App\Models\Task;
use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;


class CommentController extends Controller
{
    public function store(CreateCommentRequest $request, Task $task)
    {
        $validatedData = $request->validated();

        $comment = $task->comments()->create($validatedData);

        return new CommentResource($comment);
    }
}
