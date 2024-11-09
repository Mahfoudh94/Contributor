<?php

namespace App\Http\Resources;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RepoResource extends JsonResource
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
            'name' => $this->name,
            'full_name' => $this->full_name,
            'description' => $this->description,
            'url' => $this->html_url,
            'language' => $this->language,
            'stargazers_count' => $this->stargazers_count,
            'forks_count' => $this->forks_count,
            'open_issues_count' => $this->open_issues_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'owner' => [
                'login' => $this->owner->login,
                'avatar_url' => $this->owner->avatar_url,
                'url' => $this->owner->html_url,
            ],
        ];
    }
}
