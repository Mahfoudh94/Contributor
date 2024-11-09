<?php

namespace App\Actions\Github;

use App\Http\Resources\RepoResource;
use Exception;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class GetReps
{
    use AsAction;

    /**
     * @throws Exception
     */
    public function handle()
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
