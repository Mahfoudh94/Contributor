<?php

namespace App\Actions\Github;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class CheckForkExists
{
    use AsAction;


    /**
     * @param string $githubUsername
     * @param string $repoName
     * @param string $githubPublicToken
     * @return bool
     * @throws ConnectionException
     */
    public function handle(string $githubUsername, string $repoName, string $githubPublicToken): bool
    {
        $response = Http::withToken($githubPublicToken)
            ->get("https://api.github.com/repos/$githubUsername/$repoName");

        return $response->successful();
    }
}
