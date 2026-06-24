<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Project;
use App\Enums\TaskStatus;
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
            'name' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(TaskStatus::values()),
            'priority' => fake()->randomElement(['low', 'medium', 'high', 'critical']),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'created_by' => User::factory(),
            'project_id' => Project::factory(),
        ];
    }



    // Status Methods
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'in_progress',
        ]);
    }
    
    public function inReview(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'in_review',
        ]);
    }
    
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }



    // Priority Methods

    public function lowPriority(): static 
    {
        return $this->state(fn (array $attributes) => [
            'priority' => 'low',
        ]);
    }

    public function mediumPriority(): static 
    {
        return $this->state(fn (array $attributes) => [
            'priority' => 'medium',
        ]);
    }
    
    public function highPriority(): static 
    {
        return $this->state(fn (array $attributes) => [
            'priority' => 'high',
        ]);
    }
    
    public function criticalPriority(): static 
    {        
        return $this->state(fn (array $attributes) => [
            'priority' => 'critical',
            ]);
    }
}
    
