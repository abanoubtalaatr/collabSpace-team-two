<?php


namespace App\Actions\Conversation;

use App\Models\Project;
use Illuminate\Auth\Access\AuthorizationException;


class GetProjectConversationAction
{
    public function execute(Project $project)
    {
        $isMember = $project->members()
            ->where('user_id', auth()->id())
            ->exists();

        if (! $isMember) {
            throw new AuthorizationException(
                'You are not a member of this project.'
            );
        }
        return $project->load('groupConversation')
            ->groupConversation;
    }
}
