<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\Building::factory(5)
            ->has(
                \App\Models\Task::factory(4)
                    ->has(\App\Models\Comment::factory(3), 'comments')
            )
            ->create();
    }
}
