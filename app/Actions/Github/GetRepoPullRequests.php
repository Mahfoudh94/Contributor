<?php

namespace App\Actions\Github;

use App\Http\Resources\PullRequestResource;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class GetRepoPullRequests
{
    use AsAction;

    /**
     * @throws ConnectionException
     * @throws Exception
     */
    public function handle(string $repo, string $branch = null)
    {
        $githubAccount = auth()->user()->githubAccount;

        $queryParams = [];

        if ($branch) {
            $queryParams['base'] = $branch;
        }

        $response = Http::withToken($githubAccount->github_token)
            ->get("https://api.github.com/repos/{$githubAccount->account_name}/{$repo}/pulls", $queryParams);

        if ($response->successful()) {
            $pullRequest = $response->object();
            return PullRequestResource::collection($pullRequest);
        }
        throw new Exception();
    }
}
