<?php


namespace App\Actions\Conversation;

use App\Models\Conversation;
use App\Models\Project;
use Illuminate\Auth\Access\AuthorizationException;


class StartPrivateConversationAction
{

    public function execute(Project $project, int $userId): Conversation
    {
        $currentUserId = auth()->id();

        $currentUserExists = $project->members()
            ->where('user_id', $currentUserId)
            ->exists();

        if (! $currentUserExists) {
            throw new AuthorizationException(
                'You are not a member of this project.'
            );
        }

        $targetUserExists = $project->members()
            ->where('user_id', $userId)
            ->exists();

        if (! $targetUserExists) {
            throw new AuthorizationException(
                'Selected user is not a member of this project.'
            );
        }

        if ($currentUserId == $userId) {
            throw new AuthorizationException(
                'You cannot start a conversation with yourself.'
            );
        }

        $conversation = Conversation::where('project_id', $project->id)
            ->where('type', 'private')
            ->whereHas('participants', function ($query) use ($currentUserId) {
                $query->where('user_id', $currentUserId);
            })
            ->whereHas('participants', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->withCount('participants')
            ->having('participants_count', 2)
            ->first();

        if ($conversation) {
            return $conversation->load('participants');
        }

        $conversation = Conversation::create([
            'project_id' => $project->id,
            'type'       => 'private',
            'created_by' => $currentUserId,
        ]);

        $conversation->participants()->attach([
            $currentUserId,
            $userId,
        ]);

        return $conversation->load('participants');
    }
}
