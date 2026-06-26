<?php

namespace App\Http\Controllers\Api;

use App\Actions\Message\DeleteMessageAction;
use App\Actions\Message\ListMessagesAction;
use App\Actions\Message\MarkMessageAsReadAction;
use App\Actions\Message\SendMessageAction;
use App\Actions\Message\UpdateMessageAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Models\Message;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected ListMessagesAction $listMessages,
        protected SendMessageAction $sendMessage,
        protected UpdateMessageAction $updateMessage,
        protected DeleteMessageAction $deleteMessage,
        protected MarkMessageAsReadAction $markMessageAsRead,
    ) {}

    public function index(Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        $messages = $this->listMessages->execute($conversation);

        return $this->successResponse(
            MessageResource::collection($messages),
            'Messages retrieved successfully'
        );
    }

    public function store(
        StoreMessageRequest $request,
        Conversation $conversation
    ) {

        $this->authorize('view', $conversation);

        $message = $this->sendMessage->execute(
            $conversation,
            $request->validated()
        );

        return $this->successResponse(
            new MessageResource($message),
            'Message sent successfully',
            201
        );
    }

    public function update(
        UpdateMessageRequest $request,
        Message $message
    ) {
        $this->authorize('update', $message);

        $message = $this->updateMessage->execute(
            $message,
            $request->validated()
        );

        return $this->successResponse(
            new MessageResource($message),
            'Message updated successfully'
        );
    }

    public function destroy(Message $message)
    {
        $this->authorize('delete', $message);

        $this->deleteMessage->execute($message);

        return $this->successResponse(
            null,
            'Message deleted successfully'
        );
    }

    public function markAsRead(Message $message)
    {
        $this->authorize('view', $message);

        $this->markMessageAsRead->execute($message);

        return $this->successResponse(
            null,
            'Message marked as read'
        );
    }
}
