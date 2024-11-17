<?php

namespace App\Actions\Github;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateFork
{
    use AsAction;

    /**
     * @throws ConnectionException
     */
    public function handle(string $owner, string $repo): array
    {
        $githubAccount = auth()->user()->githubAccount;
        $response = Http::withToken($githubAccount->github_token)
            ->post("https://api.github.com/repos/{$owner}/{$repo}/forks");

        return $response->json();
    }
}
