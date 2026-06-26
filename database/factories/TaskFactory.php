<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
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
    return [
        'name' => $this->faker->sentence(4),
        'description' => $this->faker->paragraph,
        'status' => $this->faker->randomElement(['pending', 'in_progress', 'completed']),
        'project_id' => Project::inRandomOrder()->first()?->id ?? 1, // <-- السحر هنا: بيجيب آيدي مشروع عشوائي موجود فعلاً في الداتا بيز
        'team_id' => 1,
    ];
}
}
