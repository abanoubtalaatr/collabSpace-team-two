<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TeamController;

// Projects Routes:
Route::apiResource('projects', ProjectController::class);

//Team Routes:

Route::apiResource('teams' , TeamController::class);

Route::post('teams/{team}/assign_members' , [TeamController::class , 'assignMembers']);
Route::post('teams/{team}/assign_projects' , [TeamController::class , 'assignProjects']);
