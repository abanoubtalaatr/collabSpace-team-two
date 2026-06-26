<?php

namespace App\Http\Resources\Team;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
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
            'name' =>$this->name,
            'members_count' => $this->whenCounted('users'),
            'active_projects_count' => $this->whenCounted('projects'),
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }
}
