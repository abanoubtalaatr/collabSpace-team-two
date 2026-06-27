<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\MeetingAiSummaryController;
use App\Http\Controllers\Api\MeetingController;
use App\Http\Controllers\Api\MeetingTranscriptController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\Task\AssignTeamToTaskController;
use App\Http\Controllers\Api\Task\BoardTaskController;
use App\Http\Controllers\Api\Task\ProjectTaskController;
use App\Http\Controllers\Api\Task\TaskAttachmentController;
use App\Http\Controllers\Api\Task\TaskController;
use App\Http\Controllers\Api\Task\UpdateTaskStatusController;
use App\Http\Controllers\FileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AiChatController;


Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware([
    'auth:sanctum',
    \App\Http\Middleware\UpdateLastSeen::class,
])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('projects', ProjectController::class);

    Route::get('conversations', [ConversationController::class, 'index']);
    Route::get('conversations/{conversation}', [ConversationController::class, 'show']);
    Route::post('projects/{project}/conversations/private', [ConversationController::class, 'startPrivate']);
    Route::get('projects/{project}/conversation', [ConversationController::class, 'getProjectConversation']);

    Route::get('conversations/{conversation}/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('conversations/{conversation}/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::put('messages/{message}', [MessageController::class, 'update'])->name('messages.update');
    Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
    Route::post('messages/{message}/read', [MessageController::class, 'markAsRead'])->name('messages.markAsRead');

Route::apiResource('meeting-ai-summaries', MeetingAiSummaryController::class);



Route::post('/ask-ai', [AiChatController::class, 'ask']);
    Route::apiResource('meetings', MeetingController::class);
    Route::apiResource('meeting-transcripts', MeetingTranscriptController::class);
    Route::apiResource('meeting-ai-summaries', MeetingAiSummaryController::class);

    Route::prefix('projects/{project}')->group(function () {
        Route::get('files', [FileController::class, 'indexForProject']);
        Route::post('files', [FileController::class, 'uploadToProject']);
    });

    Route::prefix('tasks/{task}')->group(function () {
        Route::get('files', [FileController::class, 'indexForTask']);
        Route::post('files', [FileController::class, 'uploadToTask']);
    });

    Route::prefix('files/{file}')->group(function () {
        Route::get('/', [FileController::class, 'show']);
        Route::get('/download', [FileController::class, 'download']);
        Route::delete('/', [FileController::class, 'destroy']);
    });

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

    Route::post(
        'conversations/{conversation}/typing',
        [MessageController::class, 'typing']
    )->name('messages.typing');


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

    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('projects.tasks', ProjectTaskController::class)->scoped(['project' => 'id'])->only(['index', 'store']);
    Route::apiResource('tasks.attachments', TaskAttachmentController::class)->scoped(['task' => 'id'])->only(['index', 'store']);
    Route::put('/tasks/{task}/teams', AssignTeamToTaskController::class);
    Route::put('/tasks/{task}/status', UpdateTaskStatusController::class);
    Route::get('/tasks/board', BoardTaskController::class)->name('tasks.kanban');
});
