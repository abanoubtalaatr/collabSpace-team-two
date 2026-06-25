<?php

namespace App\Actions\Message;

use App\Models\Message;
use App\Models\MessageRead;

class MarkMessageAsReadAction
{

    public function execute(Message $message): ?MessageRead
    {
    if ($message->sender_id === auth()->id()) {
        return null;
    }

    return MessageRead::firstOrCreate(
        [
            'message_id' => $message->id,
            'user_id' => auth()->id(),
        ],
        [
            'read_at' => now(),
        ]
    );
}
}
