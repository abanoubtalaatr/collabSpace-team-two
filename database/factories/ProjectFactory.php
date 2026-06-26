<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; // <-- تأكد إن السطر ده موجود فوق عشان الـ slug يشتغل

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