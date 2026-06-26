<?php

namespace App\Actions\Task;

use App\Models\Task;

class UpdateTaskStatusAction
{
    public function execute(Task $task, string $newStatus) 
    {
        $allowed = ['pending', 'in_progress', 'completed'];
        if (!in_array($newStatus, $allowed)) {
            throw new \InvalidArgumentException('Invalid status');
        }

        $task->update(['status' => $newStatus]);
        return $task;        
    }
}
