<?php

namespace App\Actions\Task;

use App\Models\Task;

class AssignTeamToTaskAction
{
    public function execute(Task $task, array $teams)
    {
        $task->teams()->sync($teams);
        return $task;
    }
}
