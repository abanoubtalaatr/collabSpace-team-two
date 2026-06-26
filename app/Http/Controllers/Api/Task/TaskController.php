<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\Api\StoreTaskRequest;
use App\Trait\ApiResponse;
use App\Actions\Task\CreateTaskAction;
use App\Actions\Task\DeleteTaskAction;
use App\Actions\Task\ListTasksAction;
use App\Actions\Task\ShowTaskAction;
use App\Actions\Task\UpdateTaskAction;
use App\Enums\TaskStatus;

class TaskController extends Controller
{
    use ApiResponse;

    public function __construct(
        private ListTasksAction $listTasksAction,
        private CreateTaskAction $createTaskAction,
        private ShowTaskAction $showTaskAction,
        private UpdateTaskAction $updateTaskAction,
        private DeleteTaskAction $deleteTaskAction,
    ) {}


    /**
     * List all tasks
     */
    public function index(Request $request) 
    {

        $tasks = $this->listTasksAction->execute(
                $request, 
                perPage: $request->input('per_page', 10),
                page: $request->input('page', 1),
            );

        return $this->successResponse($tasks, 'Tasks fetched successfully');
    }

    /**
     * Create a new task
     */
    public function store(StoreTaskRequest $request)
    {
        $task = $this->createTaskAction->execute($request);
        return $this->successResponse($task, 'Task created successfully');
    }

    /**
     * Show a task
     */
    public function show(Task $task) 
    {
        $task = $this->showTaskAction->execute($task);
        return $this->successResponse($task, 'Task fetched successfully');
    }


    /**
     * Update a task
     */
    public function update(Task $task, Request $request)
    {
        $task = $this->updateTaskAction->execute($task, $request);
        return $this->successResponse($task, 'Task updated successfully');
    }


    /**
     * Delete a task
     */
    public function destroy(Task $task)
    {
        $this->deleteTaskAction->execute($task);
        return $this->successResponse(null, 'Task deleted successfully');
    }




}
