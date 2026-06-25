<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\Task\UpdateTaskStatusController;
use App\Http\Controllers\Api\Task\TaskController;
use App\Http\Controllers\Api\Task\TaskAttachmentController;
use App\Http\Controllers\Api\Task\ProjectTaskController;
use App\Http\Controllers\Api\Task\BoardTaskController;
use App\Http\Controllers\Api\Task\AssignTeamToTaskController;


Route::middleware(['auth:sanctum','throttle:60,1'])->group(function () {
    Route::apiResource('projects', ProjectController::class);


    // Task Routes: 
    // ------------------------------------------------------------
    Route::apiResource('tasks', TaskController::class); 
    Route::apiResource('projects.tasks', ProjectTaskController::class)->scoped(['project' => 'id'])->only(['index', 'store']); 
    Route::apiResource('tasks.attachments', TaskAttachmentController::class)->scoped(['task' => 'id'])->only(['index', 'store']);
    Route::put('/tasks/{task}/teams', AssignTeamToTaskController::class)->scoped(['task' => 'id']);
    Route::put('/tasks/{task}/status', UpdateTaskStatusController::class);
    Route::get('/tasks/board', BoardTaskController::class)->name('tasks.kanban');
});