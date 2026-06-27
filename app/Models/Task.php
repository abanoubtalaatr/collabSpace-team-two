<?php

namespace App\Models;

use App\Enums\ProjectPriority;
use App\Enums\TaskStatus;
use App\Enums\TaskPriority;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory; 

    protected $fillable = ['project_id', 'name', 'description', 'status', 'priority', 'start_date', 'end_date', 'created_by'];

    // Casts
    protected $casts = [
        'status' => TaskStatus::class,
        'priority' => ProjectPriority::class
    ];


    // Relationships
    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }

    public function attachments() 
    {
        return $this->belongsToMany(File::class, 'task_attachment', 'task_id', 'file_id');
    }
}
