<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Actions\Task\CreateTaskAction;
use App\Actions\Task\ListTasksAction;
use App\Models\Project;
use App\Http\Requests\Api\StoreTaskRequest;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{
    use ApiResponse;

    
    public function __construct(
        private ListTasksAction $listTasksAction, 
        private CreateTaskAction $createTaskAction
    ) {}


    /**
     * List all tasks of a project
     */
    public function index(Project $project, Request $request) 
    {
        $request->merge(['project_id' => $project->id]);

        $tasks = $this->listTasksAction->execute($request);
        return $this->successResponse($tasks, 'Tasks fetched successfully');
    }

    /**
     * Create a new task for a project
     */
    public function store(Project $project, StoreTaskRequest $request)
    {
        $request->merge(['project_id' => $project->id]);
        $task = $this->createTaskAction->execute($request, $project);
        return $this->successResponse($task, 'Task created successfully');
    }
}
