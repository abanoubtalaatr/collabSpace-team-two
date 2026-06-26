<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingAiSummary extends Model
{

    protected $fillable = ['meeting_id', 'summary', 'key_points', 'decisions', 'action_items'];

    // عشان لارافيل يحول الـ JSON لـ Array تلقائياً في الـ PHP
    protected $casts = [
        'key_points' => 'array',
        'decisions' => 'array',
        'action_items' => 'array',
    ];

    
    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
}
