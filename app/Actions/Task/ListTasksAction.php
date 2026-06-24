<?php

namespace App\Actions\Task;

use App\Models\Project;

class ListTasksAction
{
    public function execute(Project $project) 
    {
        return $project->tasks()->get()->groupBy('status'); // group tasks by status
    }
}
