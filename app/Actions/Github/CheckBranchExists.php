<?php

namespace App\Actions\Github;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class CheckBranchExists
{
    use AsAction;

    /**
     * @param string $githubUsername
     * @param string $repoName
     * @param string $branchName
     * @param string $githubPublicToken
     * @return bool
     * @throws ConnectionException
     */
    public function handle(string $githubUsername, string $repoName, string $branchName, string $githubPublicToken): bool
    {
        // Make a request to check the branch existence
        $response = Http::withToken($githubPublicToken)
            ->get("https://api.github.com/repos/$githubUsername/$repoName/branches/$branchName");

        return $response->successful();
    }
}
