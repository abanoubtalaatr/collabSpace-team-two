<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\FileController;


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
