<?php

namespace App\Actions\Github;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateBranch
{
    use AsAction;


    /**
     * @param string $githubUsername
     * @param string $repoName
     * @param string $branchName
     * @param string $githubPrivateToken
     * @param string $sha
     * @return mixed
     * @throws ConnectionException
     */
    public function handle(string $githubUsername, string $repoName, string $branchName, string $githubPrivateToken, string $sha): mixed
    {
        $response = Http::withToken($githubPrivateToken)
            ->post("https://api.github.com/repos/$githubUsername/$repoName/git/refs", [
                'ref' => "refs/heads/$branchName",
                'sha' => $sha
            ]);

        return $response->json();
    }
}
