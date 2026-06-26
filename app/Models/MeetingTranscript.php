<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingTranscript extends Model
{

    protected $fillable = ['meeting_id', 'user_id', 'text', 'timestamp'];

    // كل سطر تفريغ نصي بينتمي لاجتماع معين
    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    // كل سطر تفريغ نصي بينتمي للمستخدم اللي قاله
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
