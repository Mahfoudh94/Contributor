<?php

namespace App\Actions\Github;

use App\Http\Resources\GitHubRepoResource;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGithubRepositories
{
    use AsAction;

    /**
     * @throws ConnectionException
     */
    public function handle()
    {
        $githubAccount = auth()->user()->githubAccount;

        $repos = Http::withToken($githubAccount->github_token)
            ->get("https://api.github.com/users/{$githubAccount->account_name}/repos")->collect();

        return GitHubRepoResource::collection($repos);
    }
}
