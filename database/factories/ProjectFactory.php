<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ProjectStatus;
use App\Enums\ProjectPriority;
use App\Models\User;
/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->dateTimeBetween('now', '+10 days'),
            'status' => $this->faker->randomElement(ProjectStatus::cases()),
            'priority' => $this->faker->randomElement(ProjectPriority::cases()),
            'created_by' => User::factory(),
        ];
    }
}
