<?php

namespace App\Http\Controllers\Api;

use App\Actions\Conversation\GetProjectConversationAction;
use App\Actions\Conversation\ListConversationsAction;
use App\Actions\Conversation\ShowConversationAction;
use App\Actions\Conversation\StartPrivateConversationAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StartPrivateConversationRequest;
use App\Http\Resources\ConversationResource;
use App\Models\Conversation;
use App\Models\Project;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class ConversationController extends Controller
{

    use ApiResponse;


    public function __construct(
        protected ListConversationsAction $listConversations,
        protected ShowConversationAction $showConversation,
        protected StartPrivateConversationAction $startPrivateConversation,
        protected GetProjectConversationAction $getProjectConversation,
    ) {}



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $conversations = $this->listConversations->execute();

        return $this->successResponse(
            ConversationResource::collection($conversations),
            'Conversations retrieved successfully'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        $conversation = $this->showConversation->execute($conversation);

        return $this->successResponse(
            new ConversationResource($conversation),
            'Conversation retrieved successfully'
        );
    }

    public function startPrivate(
        StartPrivateConversationRequest $request,
        Project $project
    ) {
        $conversation = $this->startPrivateConversation->execute(
            $project,
            $request->validated()['user_id']
        );

        return $this->successResponse(
            new ConversationResource($conversation),
            'Conversation retrieved successfully',
            201
        );
    }

    public function getProjectConversation(Project $project)
    {


        $conversation = $this->getProjectConversation->execute($project);

        if (! $conversation) {
            return $this->errorResponse(
                'Project conversation not found',
                404
            );
        }

        return $this->successResponse(
            new ConversationResource($conversation),
            'Project conversation retrieved successfully'
        );
    }
}
