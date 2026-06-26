<?php

namespace App\Actions\Project;

use App\Http\Requests\Api\CreateProjectRequest;
use App\Models\Project;
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
        $project = Project::create($validated);

        // add the users if exists to the project 
        if ($request->has('users')) {
            $project->users()->attach($request->input('users'));
        }

        // add the attached files to the project
        if ($request->has('files')) {
            $project->files()->attach($request->input('files'));
        }

        // logging the project creation
        Log::info('Project created successfully', ['project_id' => $project->id, 'project_name' => $project->name]);

        return $project;
    }
}
