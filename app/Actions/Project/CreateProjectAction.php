<?php

namespace App\Actions\Project;

use App\Http\Requests\Api\CreateProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateProjectAction
{
    // TODO: Validate the data
    // TODO: create the project 
    // TODO: add the users to the project
    // TODO: add attched files to the project
    // TODO: return the project
    public function execute(CreateProjectRequest $request): Project
    {
        // Validate the data
        $validated = $request->validated();

        // Create the project
        DB::beginTransaction();
        try {
            $project = Project::create($validated);

            // // add the teams if exists to the project 
            // if ($request->has('teams')) {
            //     $project->teams()->attach($request->input('teams'));
            // }

            // // add the attached files to the project
            // if ($request->has('files')) {
            //     foreach ($request->input('files') as $file) {
            //         $project->files()->create([
            //             'name' => $file->getClientOriginalName(),
            //             'path' => $file->store('projects/' . $project->id, 'public'),
            //             'type' => $file->getClientOriginalExtension(),
            //             'size' => $file->getSize(),
            //         ]);
            //     }
            // }

            DB::commit();
            return $project;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
