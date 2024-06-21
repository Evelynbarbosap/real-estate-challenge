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
}
