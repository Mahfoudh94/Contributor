<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PullRequestResource extends JsonResource
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
            'title' => $this->title,
            'state' => $this->state,
            'user' => [
                'login' => $this->user->login,
                'avatar_url' => $this->user->avatar_url,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'url' => $this->html_url,
        ];
    }
}
