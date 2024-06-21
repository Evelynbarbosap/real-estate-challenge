<?php

namespace App\Http\Controllers\Api\v1;

use Carbon\Carbon;
use App\Models\Building;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function index(Request $request, Building $building)
    {
        $query = Task::query()
            ->where('building_id', $building->id)
            ->with(['user', 'comments.user']);

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
            $query->createdAtBetween($startDate, $endDate);
        }

        if ($request->has('assigned_to')) {
            $query->assignedTo($request->input('assigned_to'));
        }

        if ($request->has('status')) {
            $query->status($request->input('status'));
        }

        $tasks = $query->get();
        
        $formattedTasks = $this->formatTasks($tasks);

        return response()->json($formattedTasks);
    }

    public function store(CreateTaskRequest $request)
    {
        $validatedData = $request->validated();
        
        $task = Task::create($validatedData);

        return new TaskResource($task);
    }

     /**
     * Formata as tarefas conforme necessário.
     *
     * @param \Illuminate\Database\Eloquent\Collection $tasks
     * @return array
     */
    private function formatTasks($tasks)
    {
        return $tasks->map(function ($task) {
            return [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'assigned_to' => $task->user->name,
                'status' => $task->status,
                'due_date' => $task->due_date ? Carbon::parse($task->due_date)->format('d/m/Y H:i') : null,
                'comments' => $this->formatComments($task->comments),
                'created_at' => $task->created_at ? Carbon::parse($task->created_at)->format('d/m/Y H:i') : null,
                'updated_at' => $task->updated_at ? Carbon::parse($task->updated_at)->format('d/m/Y H:i') : null,
            ];
        });
    }

    /**
     * Formata os comentários conforme necessário.
     *
     * @param \Illuminate\Database\Eloquent\Collection $comments
     * @return array
     */
    private function formatComments($comments)
    {
        return $comments->map(function ($comment) {
            return [
                'id' => $comment->id,
                'comment' => $comment->comment,
                'user_id' => $comment->user->id,
                'user_name' => $comment->user->name,
                'created_at' => $comment->created_at ? Carbon::parse($comment->created_at)->format('d/m/Y H:i') : null,
                'updated_at' => $comment->updated_at ? Carbon::parse($comment->updated_at)->format('d/m/Y H:i') : null,
            ];
        });
    }
}
