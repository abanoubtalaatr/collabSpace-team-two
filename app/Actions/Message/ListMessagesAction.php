<?php

namespace App\Actions\Message;

use App\Models\Conversation;

class ListMessagesAction
{

    public function execute(Conversation $conversation)
    {
        return $conversation->messages()
            ->with([
                'sender',
                'replyTo.sender',
                'attachments',

            ])
            ->withCount('reads')
            ->latest()
            ->paginate(20);
    }
}
