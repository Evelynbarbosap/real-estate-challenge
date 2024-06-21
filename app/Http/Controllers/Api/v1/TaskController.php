<?php

namespace App\Http\Controllers\Api\v1;

use Carbon\Carbon;
use App\Models\Building;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\CreateTaskRequest;


class TaskController extends Controller
{
    public function index(Building $building)
    {
        $tasks = $building->tasks()
        ->with(['user', 'comments.user'])
        ->get()
        ->map(function ($task) {
            return [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'assigned_to' => $task->user->name,
                'status' => $task->status,
                'due_date' => $task->due_date ? Carbon::parse($task->due_date)->format('d/m/Y H:i') : null,
                'comments' => $task->comments->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'comment' => $comment->comment,
                        'user_id' => $comment->user->id,
                        'user_name' => $comment->user->name,
                        'created_at' => $comment->created_at ? Carbon::parse($comment->created_at)->format('d/m/Y H:i') : null
                    ];
                }),
                'created_at' => $task->created_at  ? Carbon::parse($task->created_at)->format('d/m/Y H:i') : null,
                'updated_at' => $task->updated_at  ? Carbon::parse($task->created_at)->format('d/m/Y H:i') : null,
            ];
        });

        return response()->json($tasks);
    }

    public function store(CreateTaskRequest $request)
    {
        $validatedData = $request->validated();
        $task = Task::create($validatedData);

        return response()->json($task, 201);
    }
}
