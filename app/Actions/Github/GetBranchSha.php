<?php

namespace App\Actions\Github;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class GetBranchSha
{
    use AsAction;
    
    /**
     * @param string $githubUsername
     * @param string $repoName
     * @param string $branchName
     * @param string $githubPublicToken
     * @return string
     * @throws ConnectionException
     */
    public function handle(string $githubUsername, string $repoName, string $branchName, string $githubPublicToken): string
    {
        $branchInfo = Http::withToken($githubPublicToken)
            ->get("https://api.github.com/repos/$githubUsername/$repoName/branches/$branchName")
            ->json();

        return $branchInfo['commit']['sha'];
    }
}
