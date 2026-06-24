<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\Api\StoreTaskRequest;
use App\Trait\ApiResponse;
use App\Actions\Task\CreateTaskAction;
use App\Actions\Task\ListTasksAction;
use App\Actions\Task\ShowTaskAction;

class TaskController extends Controller
{
    use ApiResponse;


    /**
     * List all tasks
     */
    public function index() 
    {
        return $this->successResponse(null, 'Tasks fetched successfully');
    }

    /**
     * Create a new task
     */
    public function store(Request $request)
    {
        return $this->successResponse(null, 'Task created successfully');
    }

    /**
     * Show a task
     */
    public function show(Task $task) 
    {
        
        return $this->successResponse($task, 'Task fetched successfully');
    }


    /**
     * Update a task
     */
    public function update(Task $task, Request $request)
    {
        return $this->successResponse(null, 'Task updated successfully');
    }


    /**
     * Delete a task
     */
    public function destroy(Task $task)
    {
        return $this->successResponse(null, 'Task deleted successfully');
    }




}
