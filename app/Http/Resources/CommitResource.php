<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        info($this->sha);
        return [
            'sha' => $this->sha,
            'message' => $this->commit->message,
            'author' => [
                'name' => $this->commit->author->name,
                'email' => $this->commit->author->email,
                'date' => $this->commit->author->date,
                'login' => $this->author->login,
                'avatar_url' => $this->author->avatar_url,
                'profile_url' => $this->author->html_url,
            ],
            'committer' => [
                'name' => $this->commit->committer->name,
                'email' => $this->commit->committer->email,
                'date' => $this->commit->committer->date,
                'login' => $this->committer->login,
                'avatar_url' => $this->committer->avatar_url,
                'profile_url' => $this->committer->html_url,
            ],
            'html_url' => $this->html_url,
        ];
    }
}
