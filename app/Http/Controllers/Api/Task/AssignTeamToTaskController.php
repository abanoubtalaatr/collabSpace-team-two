<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trait\ApiResponse;
use App\Actions\Task\AssignTeamToTaskAction;
use App\Models\Task;

class AssignTeamToTaskController extends Controller
{
    use ApiResponse;

    public function __construct(
        private AssignTeamToTaskAction $assignTeamToTaskAction
    ) {}

    /**
     * Handle the incoming request.
     */
    public function __invoke(Task $task, Request $request)
    {
        $task = $this->assignTeamToTaskAction->execute($task, $request->input('teams'));
        return $this->successResponse($task, 'Team assigned successfully');
    }
}
