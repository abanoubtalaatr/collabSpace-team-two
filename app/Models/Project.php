<?php

namespace App\Models;

use App\Enums\Priority;
use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'description', 'start_date', 'deadline', 'priority', 'status'];
    protected $casts = [
        'status' => ProjectStatus::class ,
        'priority' => Priority::class
    ];
    public function teams(){
        return $this->belongsToMany(Team::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function meetings(){
        return $this->hasMany(Meeting::class);
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function files(){
        return $this->hasMany(File::class);
    }
}
