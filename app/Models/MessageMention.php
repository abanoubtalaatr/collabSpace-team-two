<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageMention extends Model
{
    protected $fillable = [
        'message_id',
        'mentioned_user_id'
    ];


    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'mentioned_user_id');
    }}
