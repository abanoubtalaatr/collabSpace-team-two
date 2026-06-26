<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MeetingAiSummary;
use Illuminate\Http\Request;

class MeetingAiSummaryController extends Controller
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
        'meeting_id'   => 'required|exists:meetings,id',
        'summary'      => 'nullable|string',
        'key_points'   => 'nullable|array', 
        'decisions'    => 'nullable|array', 
        'action_items' => 'nullable|array', 
    ]);

        $aiSummary = MeetingAiSummary::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'The summary of artificial intelligence has been successfully saved',
            'data' => $aiSummary
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
