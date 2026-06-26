<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class Meeting extends Model
{

protected $fillable = [
    'project_id', 'creator_id', 'title', 'description', 
    'date', 'start_time', 'end_time', 'meeting_link', 'status'
];



    // ربط الاجتماع بالمشروع بتاعه
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // ربط الاجتماع بالمستخدم اللي كريته (الـ PM أو الـ Admin)
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    // ربط الاجتماع بالمستخدمين المعزومين فيه (Many-to-Many)
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('attendance_status')->withTimestamps();
    }

    // ربط الاجتماع بالتفريغ النصي بتاعه (One-to-Many)
    public function transcripts()
    {
        return $this->hasMany(MeetingTranscript::class);
    }

    // ربط الاجتماع بملخص الذكاء الاصطناعي (One-to-One)
    public function aiSummary()
    {
        return $this->hasOne(MeetingAiSummary::class);

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
