<?php

namespace App\Actions\Task;

use App\Models\Project;

class ListProjectTasksAction
{
    public function execute(Project $project)
    {
        return $project->tasks()->get()->groupBy('status');
    }
}
