<?php

namespace App\Models;

use App\Models\Concerns\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;


#[Fillable(['name', 'description', 'start_date', 'end_date', 'deadline', 'type', 'status', 'priority', 'created_by'])]
class Project extends Model
{
    use Filterable; 



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

    
}
