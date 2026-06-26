<?php

namespace App\Http\Resources;

use App\Http\Resources\AttachmentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'message' => $this->deleted_at ? 'This message was deleted' : $this->message,

            'conversation_id' => $this->conversation_id,

            'sender' => new UserResource($this->whenLoaded('sender')),

            'reply_to' => $this->whenLoaded('replyTo'),

            'reply_to_id' => $this->reply_to_id,

            'edited_at' => $this->edited_at,

            'deleted_at' => $this->deleted_at,

            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),

            'reads_count' => $this->whenCounted('reads'),

            'created_at' => $this->created_at,
        ];
    }
}
