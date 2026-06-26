<?php

namespace App\Actions\Task;

use App\Models\Task;
use Illuminate\Http\Request;

class UpdateTaskAction
{
    public function execute(Task $task, Request $request)
    {

        // only admin, project manager, and the user who created the task can update the task

        $task->update($request->all());
        return $task;
    }
}
