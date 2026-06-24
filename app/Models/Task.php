<?php

namespace App\Models;

use App\Enums\TaskStatus;
use App\Enums\TaskPriority;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory; 

    protected $fillable = ['project_id', 'team_id', 'name', 'description', 'status', 'priority', 'start_date', 'end_date'];

    // Casts
    protected $casts = [
        'status' => TaskStatus::class,
        'priority' => TaskPriority::class
    ];


    // Relationships
    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function attachments() 
    {
        return $this->belongsToMany(File::class, 'task_attachments');
    }


}
