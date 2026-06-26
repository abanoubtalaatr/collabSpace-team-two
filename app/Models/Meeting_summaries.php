<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting_summaries extends Model
{
    protected $fillable = ['meeting_id', 'summary', 'decisions_made', 'action_items', 'risks', 'next_steps'];

    public function meeting(){
        return $this->belongsTo(Meeting::class);
    }
}
