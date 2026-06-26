<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project; 
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // check if there is any project create 10 projects 
        $projects = Project::all();
        if ($projects->isEmpty()) {
            $projects = Project::factory(5)->create();
        }

        //create 15 tasks for each project
        foreach ($projects as $project) {

            // Task with pending status and low priority 
            Task::factory(5)->pending()->lowPriority()->create([
                'project_id' => $project->id,
                'created_by' => $project->created_by,
            ]);
            Task::factory(5)->pending()->mediumPriority()->create([
                'project_id' => $project->id,
                'created_by' => $project->created_by,
            ]);
            Task::factory(5)->pending()->highPriority()->create([
                'project_id' => $project->id,
                'created_by' => $project->created_by,
            ]);


            // Task with in progress status and low priority 
            Task::factory(5)->inProgress()->lowPriority()->create([
                'project_id' => $project->id,
                'created_by' => $project->created_by,
            ]);
            Task::factory(5)->inProgress()->mediumPriority()->create([
                'project_id' => $project->id,
                'created_by' => $project->created_by,
            ]);
            Task::factory(5)->inProgress()->highPriority()->create([
                'project_id' => $project->id,
                'created_by' => $project->created_by,
            ]);




            // Task with cancelled status and low priority 
            Task::factory(5)->inReview()->lowPriority()->create([
                'project_id' => $project->id,
                'created_by' => $project->created_by,
            ]);
            Task::factory(5)->inReview()->mediumPriority()->create([
                'project_id' => $project->id,
                'created_by' => $project->created_by,
            ]);
            Task::factory(5)->inReview()->highPriority()->create([
                'project_id' => $project->id,
                'created_by' => $project->created_by,
            ]);


            // Task with completed status and low priority 
            Task::factory(5)->completed()->lowPriority()->create([
                'project_id' => $project->id,
                'created_by' => $project->created_by,
            ]);
            Task::factory(5)->completed()->mediumPriority()->create([
                'project_id' => $project->id,
                    'created_by' => $project->created_by,
            ]);
            Task::factory(5)->completed()->highPriority()->create([
                'project_id' => $project->id,
                'created_by' => $project->created_by,
            ]);


        }
    }


    
}
