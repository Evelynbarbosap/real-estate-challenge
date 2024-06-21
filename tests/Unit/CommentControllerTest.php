<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskCommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_comment_for_task()
    {
        $task = Task::factory()->create();
        $user = User::factory()->create();

        $commentData = [
            'comment' => 'This is a test comment.',
            'user_id' => $user->id
        ];

        $response = $this->post("/api/v1/tasks/{$task->id}/comments", $commentData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('comments', [
            'comment' => 'This is a test comment.',
            'user_id' =>$user->id
        ]);
    }

    public function test_comment_for_task_requires_comment()
    {
        $task = Task::factory()->create();
        $user = User::factory()->create();

        $commentData = [
            'user_id' => $user->id
        ];

        $response = $this->post("/api/v1/tasks/{$task->id}/comments", $commentData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('comment');
    }

    
    public function test_comment_for_task_requires_user_id()
    {
        $task = Task::factory()->create();

        $commentData = [
            'comment' => 'This is a test comment.'
        ];

        $response = $this->post("/api/v1/tasks/{$task->id}/comments", $commentData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('user_id');
    }
}
