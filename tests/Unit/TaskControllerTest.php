<?php

namespace Tests\Unit;


use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Building;
use App\Models\Task;
use App\Models\User;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_method_creates_task()
    {
        $building = Building::factory()->create();
        $user = User::factory()->create();

        $status = ['open', 'progress', 'completed', 'rejected'];
        $randomStatus = $status[array_rand($status)];
        
        $currentDate = Carbon::now()->format('Y-m-d');

        $taskData = [
            'title' => 'Unit Test Task',
            'description' => 'This is a test task',
            'assigned_to' => $user->id,
            'status' => $randomStatus,
            "due_date" => $currentDate
        ];

        $response = $this->post("/api/v1/tasks/building/{$building->id}", $taskData);

        $response->assertStatus(201);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Unit Test Task',
            'description' => 'This is a test task',
            'building_id' => $building->id,
        ]);
    }

    public function test_store_method_task_requires_title()
    {
        $building = Building::factory()->create();
        $user = User::factory()->create();

        $status = ['open', 'progress', 'completed', 'rejected'];
        $randomStatus = $status[array_rand($status)];
        
        $currentDate = Carbon::now()->format('Y-m-d');

        $taskData = [
            'title' => Null,
            'description' => 'This is a test task',
            'assigned_to' => $user->id,
            'status' => $randomStatus,
            "due_date" => $currentDate
        ];

        $response = $this->json('POST', "/api/v1/tasks/building/{$building->id}", $taskData);
      
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title');
    }
    
    public function test_store_method_task_requires_status()
    {
        $building = Building::factory()->create();
        $user = User::factory()->create();

        $currentDate = Carbon::now()->format('Y-m-d');

        $taskData = [
            'title' => 'Unit Test Task',
            'description' => 'This is a test task',
            'assigned_to' => $user->id,
            "due_date" => $currentDate
        ];

        $response = $this->json('POST', "/api/v1/tasks/building/{$building->id}", $taskData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('status');
    }
    
    public function test_store_method_task_requires_assigned_to()
    {
        $building = Building::factory()->create();
        
        $status = ['open', 'progress', 'completed', 'rejected'];
        $randomStatus = $status[array_rand($status)];
        
        $currentDate = Carbon::now()->format('Y-m-d');

        $taskData = [
            'title' => 'Unit Test Task',
            'status' => $randomStatus,
            'description' => 'This is a test task',
            "due_date" => $currentDate
        ];

        $response = $this->json('POST', "/api/v1/tasks/building/{$building->id}", $taskData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('assigned_to');
    }
}
