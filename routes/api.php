<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ProjectController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware([
    'auth:sanctum',
     \App\Http\Middleware\UpdateLastSeen::class
    ])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);



    // Projects Routes: 
    Route::apiResource('projects', ProjectController::class);

    // Conversations Routes: 
    Route::get(
        'conversations',
        [ConversationController::class, 'index']
    );

    Route::get(
        'conversations/{conversation}',
        [ConversationController::class, 'show']
    );

    Route::post(
        'projects/{project}/conversations/private',
        [ConversationController::class, 'startPrivate']
    );

    Route::get(
        'projects/{project}/conversation',
        [ConversationController::class, 'getProjectConversation']
    );

    // Messages Routes: 

    Route::get(
        'conversations/{conversation}/messages',
        [MessageController::class, 'index']
    )->name('messages.index');

    Route::post(
        'conversations/{conversation}/messages',
        [MessageController::class, 'store']
    )->name('messages.store');

    Route::put(
        'messages/{message}',
        [MessageController::class, 'update']
    )->name('messages.update');

    Route::delete(
        'messages/{message}',
        [MessageController::class, 'destroy']
    )->name('messages.destroy');

    Route::post(
        'messages/{message}/read',
        [MessageController::class, 'markAsRead']
    )->name('messages.markAsRead');
});
