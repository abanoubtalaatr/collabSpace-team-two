<?php

use App\Http\Controllers\Api\MeetingAiSummaryController;
use App\Http\Controllers\Api\MeetingController;
use App\Http\Controllers\Api\MeetingTranscriptController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AiChatController;



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



Route::post('/ask-ai', [AiChatController::class, 'ask']);