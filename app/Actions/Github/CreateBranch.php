<?php

namespace App\Actions\Github;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateBranch
{
    use AsAction;

    /**
     * @throws ConnectionException
     */
    public function handle(string $owner, string $repo, string $taskBranchName)
    {
        $githubAccount = auth()->user()->githubAccount;

        // First, get the SHA of the base branch
        $branchInfo = Http::withToken($githubAccount->github_token)
            ->get("https://api.github.com/repos/{$owner}/{$repo}/branches/{$taskBranchName}")
            ->json();

        $sha = $branchInfo['commit']['sha'];

        // Create the new branch based on the base branch's SHA
        $response = Http::withToken($githubAccount->github_token)
            ->post("https://api.github.com/repos/{$owner}/{$repo}/git/refs", [
                'ref' => "refs/heads/{$taskBranchName}",
                'sha' => $sha
            ]);

        return $response->json();
    }
}
