<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MeetingAiSummaryController;
use App\Http\Controllers\Api\MeetingController;
use App\Http\Controllers\Api\MeetingTranscriptController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\Task\AssignTeamToTaskController;
use App\Http\Controllers\Api\Task\BoardTaskController;
use App\Http\Controllers\Api\Task\ProjectTaskController;
use App\Http\Controllers\Api\Task\TaskAttachmentController;
use App\Http\Controllers\Api\Task\TaskController;
use App\Http\Controllers\Api\Task\UpdateTaskStatusController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\FileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::apiResource('meetings', MeetingController::class);

//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
Route::apiResource('meeting-transcripts', MeetingTranscriptController::class); //||
//                                                                             //||
// Route::get('meetings', [MeetingController::class, 'index']);                //||
// Route::post('meetings', [MeetingController::class, 'store']);               //||
// Route::get('meetings/{id}', [MeetingController::class, 'show']);            //||
// Route::put('meetings/{id}', [MeetingController::class, 'update']);          //||
// Route::delete('meetings/{id}', [MeetingController::class, 'destroy']);      //||
//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

Route::apiResource('meeting-ai-summaries', MeetingAiSummaryController::class);
Route::prefix('auth')->group(function () {

    // Public routes
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password',  [AuthController::class, 'resetPassword'])->name('password.reset');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum','throttle:60,1'])->group(function () {
    Route::apiResource('projects', ProjectController::class);

//files routes :
Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('projects/{project}')->group(function () {
        Route::get('files',  [FileController::class, 'indexForProject']);
        Route::post('files', [FileController::class, 'uploadToProject']);
    });

    Route::prefix('tasks/{task}')->group(function () {
        Route::get('files',  [FileController::class, 'indexForTask']);
        Route::post('files', [FileController::class, 'uploadToTask']);
    });

    Route::prefix('files/{file}')->group(function () {
        Route::get('/',         [FileController::class, 'show']);
        Route::get('/download', [FileController::class, 'download']);
        Route::delete('/',      [FileController::class, 'destroy']);
    });
});
//Team Routes:


    // Task Routes: 
    // ------------------------------------------------------------
    Route::apiResource('tasks', TaskController::class); 
    Route::apiResource('projects.tasks', ProjectTaskController::class)->scoped(['project' => 'id'])->only(['index', 'store']); 
    Route::apiResource('tasks.attachments', TaskAttachmentController::class)->scoped(['task' => 'id'])->only(['index', 'store']);
    Route::put('/tasks/{task}/teams', AssignTeamToTaskController::class);
    Route::put('/tasks/{task}/status', UpdateTaskStatusController::class);
    Route::get('/tasks/board', BoardTaskController::class)->name('tasks.kanban');
});
