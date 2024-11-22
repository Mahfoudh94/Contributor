<?php

namespace App\Actions\Github;

use App\Http\Resources\RepoResource;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class GetRepositories
{
    use AsAction;

    /**
     * @throws Exception
     */
    public function handle(): AnonymousResourceCollection
    {
        $githubAccount = auth()->user()->githubAccount;

        $response = Http::withToken($githubAccount->github_token)
            ->get("https://api.github.com/users/{$githubAccount->account_name}/repos");

        if ($response->successful()) {
            $repos = $response->object();
            return RepoResource::collection($repos);
        }
        throw new Exception();
    }
}
