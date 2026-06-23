<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = ['project_id', 'creator_id', 'title', 'description', 'date', 'start_time', 'end_time', 'meeting_link'];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function creator(){
        return $this->belongsTo(User::class , 'creator_id');
    }

    public function participants(){
        return $this->belongsToMany(User::class);
    }

    public function meetingSummaries(){
        return $this->hasOne(Meeting_summaries::class);
    }
}
