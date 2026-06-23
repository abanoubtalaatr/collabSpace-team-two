<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\CreateTeam;
use App\Http\Requests\Team\UpdateTeam;
use App\Http\Resources\Team\TeamResource;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::withCount(['users' , 'projects'])->get();

        return response()->json([TeamResource::collection($teams)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTeam $request)
    {
        $team = Team::create($request->validated());

        return response()->json([
            'message' => 'Team Created Successfully',
            'data' => new TeamResource($team)
        ] , 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        $team->load(['users' , 'projects']);
        return response()->json(new TeamResource($team));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeam $request, Team $team)
    {
          $team->update($request->validated());

          return response()->json([
            'message' => 'Team updated successfully',
            'data' => new TeamResource($team)
          ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();
        return response()->json([
            'message' => 'Team deleted successfully'

        ]);



    }


    //assignMembers

    public function assignMembers(Request $request , Team $team){
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);
        $team->users()->sync($request->user_ids);

        return response()->json([
            'message' => 'Members assigned to team successfully',
        ]);
    }

    //assignProjects

     public function assignProjects(Request $request , Team $team){
        $request->validate([
            'project_ids' => 'required|array',
            'project_ids.*' => 'exists:projects,id'
        ]);
        $team->users()->sync($request->project_ids);

        return response()->json([
            'message' => 'Projects assigned to team successfully',
        ]);
    }
}
