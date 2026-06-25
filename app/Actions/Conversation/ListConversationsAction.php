<?php


namespace App\Actions\Conversation;


class ListConversationsAction
{

    public function execute()
    {
        return auth()->user()
            ->conversations()
            ->with([
                'participants',
                'project',
                'messages' => function ($query) {
                    $query->latest()->limit(1);
                }
            ])
            ->latest()
            ->get();
    }
}
