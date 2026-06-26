<?php

namespace App\Actions\Message;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessageMention;
use App\Notifications\MentionNotification;
use App\Notifications\NewMessageNotification;
use Illuminate\Auth\Access\AuthorizationException;

class SendMessageAction
{

    public function execute(
        Conversation $conversation,
        array $data
    ): Message {

        $user = auth()->user();

        $isParticipant = $conversation->participants()
            ->where('user_id', $user->id)
            ->exists();

        if (! $isParticipant) {
            throw new AuthorizationException(
                'You are not a participant in this conversation.'
            );
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $user->id,
            'reply_to_id'     => $data['reply_to_id'] ?? null,
            'message'         => $data['message'],
        ]);

        /*
        |----------------------------------------
        | Attachments
        |----------------------------------------
        */

        if (request()->hasFile('attachments')) {

            foreach (request()->file('attachments') as $file) {

                $path = $file->store('chat-attachments', 'public');

                $message->attachments()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        /*
        |----------------------------------------
        | Mentions
        |----------------------------------------
        */

        preg_match_all('/@([A-Za-z0-9_]+)/',  $data['message'], $matches);


        $mentionedUsers = $conversation->participants()
            ->whereIn('name', $matches[1])
            ->get();

        foreach ($mentionedUsers as $mentionedUser) {

            MessageMention::firstOrCreate([
                'message_id' => $message->id,
                'mentioned_user_id' => $mentionedUser->id,
            ]);

            if ($mentionedUser->id !== $user->id) {
                $mentionedUser->notify(
                    new MentionNotification($message)
                );
            }
        }

        $message->loadMissing([
            'sender',
            'replyTo.sender',
            'attachments',
            'mentions',
        ]);

        event(new MessageSent($message));

        $mentionedIds = $mentionedUsers->pluck('id');

        $conversation->participants()
            ->where('user_id', '!=', $user->id)
            ->get()
            ->reject(fn($participant) => $mentionedIds->contains($participant->id))
            ->each(function ($participant) use ($message) {
                $participant->notify(
                    new NewMessageNotification($message)
                );
            });

        return $message;
    }
}
