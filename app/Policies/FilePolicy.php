<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;

class FilePolicy
{
  
    public function view(User $user, File $file): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($file->uploaded_by === $user->id) {
            return true;
        }

        if ($file->fileable && method_exists($file->fileable, 'users')) {
            return $file->fileable->users->contains($user->id);
        }

        return false;
    }

   
    public function delete(User $user, File $file): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($file->uploaded_by === $user->id) {
            return true;
        }

        if ($user->role === 'project_manager') {
            return true;
        }

        return false;
    }

    
    public function upload(User $user): bool
    {
        return in_array($user->role, [
            'admin',
            'project_manager',
            'member'
        ]);
    }

    
    public function restore(User $user, File $file): bool
    {
        return $user->role === 'admin';
    }

    
    public function forceDelete(User $user, File $file): bool
    {
        return $user->role === 'admin';
    }
}