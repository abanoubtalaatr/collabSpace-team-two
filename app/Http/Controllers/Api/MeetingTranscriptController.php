<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MeetingTranscript;
use Illuminate\Http\Request;

class MeetingTranscriptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'meeting_id' => 'required|exists:meetings,id', 
            'user_id'    => 'required|exists:users,id',    
            'text'       => 'required|string',            
            'timestamp'  => 'required|string',            
    ]);

    $transcript = MeetingTranscript::create($validatedData);

    return response()->json([
        'success' => true,
        'message' => 'The Unpacked text has been successfully added',
        'data' => $transcript
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
