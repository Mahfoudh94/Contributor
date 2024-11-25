<?php

namespace App\Actions\Github;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateFork
{
    use AsAction;


    /**
     * @param string $githubUsername
     * @param string $repoName
     * @param string $githubPrivateToken
     * @return array
     * @throws ConnectionException
     */
    public function handle(string $githubUsername, string $repoName, string $githubPrivateToken): array
    {
        $response = Http::withToken($githubPrivateToken)
            ->post("https://api.github.com/repos/$githubUsername/$repoName/forks",[
                'default_branch_only' => true,
            ]);

        return $response->json();
    }
}
