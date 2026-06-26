<?php

namespace App\Models;

use App\Models\Concerns\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Enums\ProjectStatus;
use App\Enums\Priority;



class Project extends Model
{
    use Filterable; 

    protected $fillable = ['name', 'description', 'start_date', 'end_date', 'deadline', 'type', 'status', 'priority', 'created_by'];

    protected $casts = [
        'status' => ProjectStatus::class ,
        'priority' => Priority::class
    ];


    // relationships: 
    /*********************/
    public function creator() 
    { 
        return $this->belongsTo(User::class, 'created_by'); 
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class); 
    }

    public  function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_users', 'project_id', 'user_id'); 
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
