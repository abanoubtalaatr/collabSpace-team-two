<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Actions\Task\ListProjectTasksAction;
use App\Actions\Task\CreateProjectTaskAction;
use App\Models\Project;
use App\Http\Requests\Api\StoreTaskRequest;
use App\Trait\ApiResponse;

class ProjectTaskController extends Controller
{
    use ApiResponse;

    
    public function __construct(
        private ListProjectTasksAction $listProjectTasksAction, 
        private CreateProjectTaskAction $createProjectTaskAction
    ) {}


    /**
     * List all tasks of a project
     */
    public function index(Project $project) 
    {
        $tasks = $this->listProjectTasksAction->execute($project);
        return $this->successResponse($tasks, 'Tasks fetched successfully');
    }

    /**
     * Create a new task for a project
     */
    public function store(Project $project, StoreTaskRequest $request)
    {
        $task = $this->createProjectTaskAction->execute($project, $request);
        return $this->successResponse($task, 'Task created successfully');
    }
}
