<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{

    /**
     * Determine if the user can create a project.
     */
    public function create(User $user): bool
    {
        return in_array($user->role->name, ['admin', 'project_manager']);
    }

    /**
     * Determine if the user can view the project.
     */

    public function view(User $user, Project $project): bool
    {
        return $user->role === 'admin' || $user->role === 'manager' || $user->id === $project->created_by;
    }

    /**
     * Determine if the user can update the project.
     */
    public function update(User $user, Project $project): bool
    {
        if (in_array($user->role->name, ['admin', 'project_manager'])) {
            return true;
        }

        return $project->members->where('user_id', $user->id)->exists(); 
    }

    /**
     * Determine if the user can delete the project.
     */
    public function delete(User $user, Project $project): bool
    {    
        return in_array($user->role->name, ['admin', 'project_manager']);
    }

    /**
     * Determine if the user can view the project tasks.
     */
    public function viewTasks(User $user, Project $project): bool
    {
        return $this->view($user, $project);
    }
}
