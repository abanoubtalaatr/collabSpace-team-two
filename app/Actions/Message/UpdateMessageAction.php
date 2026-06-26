<?php

namespace App\Actions\Message;

use App\Models\Message;
use Illuminate\Validation\ValidationException;

class UpdateMessageAction
{

    public function execute(
        Message $message,
        array $data
    ): Message {

        if ($message->trashed()) {
            throw ValidationException::withMessages([
                'message' => 'Deleted messages cannot be edited.',
            ]);
        }

        $message->update([
            'message' => $data['message'],
            'edited_at' => now(),
        ]);

        return $message->fresh([
            'sender',
            'replyTo.sender',
            'attachments',
            'mentions',
        ]);
    }
}
