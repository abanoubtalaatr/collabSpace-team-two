<?php

namespace Database\Seeders;

use App\Models\Meeting;
use App\Models\User;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. نـكريت يوزر أساسي
        \DB::table('users')->insertOrIgnore([
            'id' => 1,
            'name' => 'Admin User',
            'email' => 'admin@collabspace.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. نـكريت تيم أساسي
        \DB::table('teams')->insertOrIgnore([
            'id' => 1,
            'name' => 'Development Team',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. نـكريت 5 مشاريع وهمية و 10 تاسكات
        \App\Models\Project::factory(5)->create();
        \App\Models\Task::factory(10)->create();
        
        // 4. نـكريت ميتنج سريع بكل الحقول الإجبارية
       // نـكريت ميتنج سريع بكل الحقول الزمنية 🎯
        \DB::table('meetings')->insert([
            'title' => 'Daily Standup Meeting',
            'description' => 'Discussing Ask AI task progress',
            'project_id' => 1,
            'creator_id' => 1,
            'date' => now()->toDateString(),      // تاريخ النهاردة (Y-m-d)
            'start_time' => '10:00:00',          // 🎯 وقت البداية
            'end_time' => '11:00:00',            // 🎯 وقت النهاية (احتياطاً لو إجباري)
            'created_at' => now(),
            'updated_at' => now(),
        $this->call([
            UserSeeder::class,
            TaskSeeder::class,
            ProjectSeeder::class,
        ]);
    } // <-- قفلة دالة الـ run اللي كانت ناقصة ومسببة الإيرور 🎯
} // قفلة الكلاس