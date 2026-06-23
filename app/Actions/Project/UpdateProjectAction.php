<?php

namespace App\Actions\Project;

use App\Http\Requests\Api\UpdateProjectRequest;
use App\Models\Project;

class UpdateProjectAction
{
    public function execute(UpdateProjectRequest $request, string $id): Project
    {
        return Project::findOrFail($id)->update($request->validated());
    }
}
