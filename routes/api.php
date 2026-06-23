<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;




// Projects Routes: 
Route::apiResource('projects', ProjectController::class);