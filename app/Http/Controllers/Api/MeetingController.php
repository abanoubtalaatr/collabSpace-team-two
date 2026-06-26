<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Meeting;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meetings = Meeting::with(['project', 'creator'])->get();

        return response()->json([
        'success' => true,
        'message' => 'All meetings were successfully brought',
        'data' => $meetings
    ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'project_id'   => 'required|exists:projects,id', 
        'creator_id'   => 'required|exists:users,id',   
        'title'        => 'required|string|max:255',     
        'description'  => 'nullable|string',             
        'date'         => 'required|date',               // (YYYY-MM-DD)
        'start_time'   => 'required|date_format:H:i',    //  (مثال: 14:30)
        'end_time'     => 'required|date_format:H:i|after:start_time', // The end time must be "after" the start time (Logic!)
        'meeting_link' => 'nullable|url',                // (URL)
        'status'       => 'nullable|in:scheduled,in_progress,completed,cancelled', 
    ]);


    $meeting = Meeting::create($validatedData);

    return response()->json([
        'success' => true,
        'message' => 'The meeting was created successfully',
        'data' => $meeting
    ], 201);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $meeting = Meeting::with(['project', 'creator', 'transcripts', 'aiSummary'])->find($id);

    if (!$meeting) {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, this meeting does not exist or has been deleted'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => 'The details of the meeting were successfully brought',
        'data' => $meeting
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $meeting = Meeting::find($id);

    if (!$meeting) {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, this meeting does not exist to edit'
        ], 404);
    }

    $validatedData = $request->validate([
        'project_id'   => 'sometimes|required',
        'creator_id'   => 'sometimes|required',
        'title'        => 'sometimes|required|string|max:255',
        'description'  => 'nullable|string',
        'date'         => 'sometimes|required|date',
        'start_time'   => 'sometimes|required|date_format:H:i',
        'end_time'     => 'sometimes|required|date_format:H:i|after:start_time',
        'meeting_link' => 'nullable|url',
        'status'       => 'nullable|in:scheduled,in_progress,completed,cancelled',
    ]);

    $meeting->update($validatedData);

    return response()->json([
        'success' => true,
        'message' => 'The meeting data has been successfully updated',
        'data' => $meeting
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $meeting = Meeting::find($id);

    if (!$meeting) {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, this meeting does not exist or has already been deleted'
        ], 404);
    }

    $meeting->delete();

    return response()->json([
        'success' => true,
        'message' => 'The meeting was successfully deleted'
        ], 200);
    }
}
