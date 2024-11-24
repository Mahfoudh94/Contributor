<?php

namespace App\Actions\Github;

use App\Models\Task;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateBranch
{
    use AsAction;

    /**
     * @param Task $task
     * @param string $githubPrivateToken
     * @return mixed
     * @throws ConnectionException
     */
    public function handle(Task $task, string $githubPrivateToken): mixed
    {
        $roomRepo = $task->room->repository;

        // First, get the SHA of the base branch
        $branchInfo = Http::withToken($githubPrivateToken)
            ->get("https://api.github.com/repos/$roomRepo->owner/$roomRepo->repository/branches/$roomRepo->branch")
            ->json();

        $sha = $branchInfo['commit']['sha'];

        // Create the new branch based on the base branch's SHA
        $response = Http::withToken($githubPrivateToken)
            ->post("https://api.github.com/repos/$roomRepo->owner/$roomRepo->repository/git/refs", [
                'ref' => "refs/heads/$task->title",
                'sha' => $sha
            ]);

        return $response->json();
    }
}
