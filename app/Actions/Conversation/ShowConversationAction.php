<?php


namespace App\Actions\Conversation;

use App\Models\Conversation;


class ShowConversationAction
{

    public function execute(Conversation $conversation): Conversation
    {
        return $conversation->load([
            'participants',
            'messages.sender',
            'messages.attachments',
            'messages.replyTo',
            'messages.reads',
            'messages.mentions',
        ]);
    }
}
