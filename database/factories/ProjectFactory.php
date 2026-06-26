<?php

namespace Database\Factories;

use App\Enums\ProjectPriority;
use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'slug' => fake()->unique()->slug(),
            'type' => 'saas',
            'start_date' => fake()->date(),
            'end_date' => fake()->dateTimeBetween('+1 day', '+30 days')->format('Y-m-d'),
            'deadline' => fake()->optional()->dateTimeBetween('+1 day', '+60 days')?->format('Y-m-d'),
            'status' => fake()->randomElement(ProjectStatus::values()),
            'priority' => fake()->randomElement(ProjectPriority::values()),
            'created_by' => User::factory(),
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ProjectStatus::COMPLETED->value,
        ]);
    }
}
