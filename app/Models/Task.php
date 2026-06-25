<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['project_id', 'team_id', 'name', 'description', 'status','completed_at', 'deadline'];
    protected $casts = [
        'status' => TaskStatus::class
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function files(){
        return $this->hasMany(File::class);
    }
}
