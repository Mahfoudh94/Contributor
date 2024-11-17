<?php

namespace App\Actions\Github;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class CheckForkExists
{
    use AsAction;

    /**
     * @throws ConnectionException
     */
    public function handle(string $developer, string $repo): bool
    {
        $githubAccount = auth()->user()->githubAccount;

        $response = Http::withToken($githubAccount->github_token)
            ->get("https://api.github.com/repos/{$developer}/{$repo}");

        return $response->successful();
    }
}
