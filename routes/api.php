<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

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
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Api\TeamController;

// Projects Routes:
Route::apiResource('projects', ProjectController::class);

// Projects Routes: 
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

Route::apiResource('teams' , TeamController::class);

Route::post('teams/{team}/assign_members' , [TeamController::class , 'assignMembers']);
Route::post('teams/{team}/assign_projects' , [TeamController::class , 'assignProjects']);
