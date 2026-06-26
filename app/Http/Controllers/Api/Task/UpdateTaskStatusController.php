<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Task\UpdateTaskStatusRequest;
use App\Models\Task;
use App\Trait\ApiResponse;
use App\Actions\Task\UpdateTaskStatusAction;

class UpdateTaskStatusController extends Controller
{
    use ApiResponse;
    
    public function __construct(private UpdateTaskStatusAction $updateTaskStatusAction)
    {
    }

    public function __invoke(Task $task, UpdateTaskStatusRequest $request)
    {
        $task = $this->updateTaskStatusAction->execute($task, $request->status);
        return $this->successResponse($task, 'Task status updated successfully');
    }
}
