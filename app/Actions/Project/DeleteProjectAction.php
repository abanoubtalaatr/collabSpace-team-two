<?php

namespace App\Actions\Project;

use App\Models\Project;
use Illuminate\Support\Facades\Log;
class DeleteProjectAction
{
    public function execute(Project $project): void
    {
        $project->deleteOrFail();

        Log::info('Project deleted successfully', ['project_id' => $project->id, 'project_name' => $project->name]);

        
    }
}
