<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name'];

    public function users(){
        return $this->belongsToMany(User::class);

    }

    public function projects(){
        return $this->belongsToMany(Project::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }
}
