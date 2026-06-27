<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; // <-- تأكد إن السطر ده موجود فوق عشان الـ slug يشتغل

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
        $name = $this->faker->sentence(3); // بنثبت الاسم في متغير أولاً

        return [
            'name' => $name,
            'slug' => Str::slug($name), // <-- بنولد الـ slug هنا تلقائياً من الاسم
            'description' => $this->faker->paragraph,
            'start_date' => now(),
            'end_date' => now()->addMonths(2),
            'type' => 'saas',
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'completed']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'created_by' => 1,
        ];
    }
}
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
