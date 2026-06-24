<?php

namespace App\Actions\Task;

use App\Models\Project;
use App\Models\Task;

class ShowTaskAction
{
    /**
     * Create a new class instance.
     */
    public function execute(Project $project, Task $task)
    {
        return $task;
    }
}
