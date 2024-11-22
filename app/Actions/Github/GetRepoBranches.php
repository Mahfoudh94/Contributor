<?php

namespace App\Actions\Github;

use App\Http\Resources\RepoBranchesResource;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\Http;

class GetRepoBranches
{
    use AsAction;

    /**
     * @throws ConnectionException
     * @throws Exception
     */
    public function handle(string $repo = null): AnonymousResourceCollection
    {
        if (!$repo) {
            return RepoBranchesResource::collection([]);
        }

        $githubAccount = auth()->user()->githubAccount;

        $response = Http::withToken($githubAccount->github_token)
            ->get("https://api.github.com/repos/{$githubAccount->account_name}/{$repo}/branches");

        if ($response->successful()) {
            $branches = $response->object();
            return RepoBranchesResource::collection($branches);
        }
        throw new Exception();
    }
}
