<?php

namespace App\Actions\Github;

use App\Http\Resources\CommitResource;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCommitsFromPullRequest
{
    use AsAction;

    /**
     * @throws ConnectionException
     * @throws Exception
     */
    public function handle($owner, $repo, $pullNumber)
    {
        $response = Http::withToken(auth()->user()->github_token)
            ->get("https://api.github.com/repos/{$owner}/{$repo}/pulls/{$pullNumber}/commits");

        if ($response->ok()) {
            //info($response->collect());
            return CommitResource::collection($response->collect());
        }

        throw new Exception("Failed to retrieve commits from GitHub API", 400);
    }
}
