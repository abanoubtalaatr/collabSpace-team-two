<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['user_id', 'project_id', 'task_id', 'file_name', 'file_path', 'file_type'];

   protected $appends = ['url', 'size_human'];

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    

    public function getUrlAttribute(): string
    {
        return Storage::url($this->path);
    }

    public function getSizeHumanAttribute(): string
    {
        $bytes = $this->size;
        if ($bytes < 1024) return $bytes . ' B';
        if ($bytes < 1048576) return round($bytes / 1024, 1) . ' KB';
        if ($bytes < 1073741824) return round($bytes / 1048576, 1) . ' MB';
        return round($bytes / 1073741824, 1) . ' GB';
    }

     //Relationships:--
    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
    public function task(){
        return $this->belongsTo(Task::class);
    }
}
