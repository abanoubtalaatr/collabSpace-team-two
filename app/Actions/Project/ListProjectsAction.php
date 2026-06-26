<?php

namespace App\Actions\Project;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ListProjectsAction
{
    public function execute(): Collection
    {
        $user = auth()->user();

        if (in_array($user->role->name, ['admin', 'project_manager'])) {
            return Project::with('members')->get(); 
        }

        return Project::whereHas('memebers', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

    }
}
