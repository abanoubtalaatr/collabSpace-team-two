<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['project_id', 'user_id', 'parent_id', 'message'];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function parent(){
        return $this->belongsTo(Message::class , 'parent_id');
    }

    public function replies(){
        return $this->hasMany(Message::class , 'parent_id');
    }
}
