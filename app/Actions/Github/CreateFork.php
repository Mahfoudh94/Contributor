<?php

namespace App\Actions\Github;

use Lorisleiva\Actions\Concerns\AsAction;

class CreateFork
{
    use AsAction;

    public function handle(string $owner, string $repo): array
    {
        $githubAccount = auth()->user()->githubAccount;
        $response = Http::withToken($githubAccount->github_token)
            ->post("https://api.github.com/repos/{$owner}/{$repo}/forks");

        return $response->json();
    }
}
