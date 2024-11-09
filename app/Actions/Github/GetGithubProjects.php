<?php

namespace App\Actions\Github;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGithubProjects
{
    use AsAction;

    /**
     * @throws ConnectionException
     */
    public function handle()
    {
        $githubAccount = auth()->user()->githubAccount;
        $response = Http::withToken($githubAccount->github_token)
            ->get("https://api.github.com/users/{{$githubAccount->account_name}}/repos");

        return $response->json();
    }
}
