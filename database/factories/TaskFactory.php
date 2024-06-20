<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Building;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = ['pending', 'completed'];

        return [
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(2),
            'assigned_to' => User::factory(),
            'building_id' => Building::factory(),
            'status' => $this->faker->randomElement($status),
            'due_date' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
        ];
    }
}
