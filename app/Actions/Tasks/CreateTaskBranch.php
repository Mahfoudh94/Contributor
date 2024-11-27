<?php

namespace App\Actions\Tasks;

use App\Actions\Github\CreateBranch;
use App\Actions\Github\GetBranchSha;
use App\Models\RoomRepo;
use App\Models\Task;
use App\Models\UserGithubAccount;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateTaskBranch
{
    use AsAction;


    /**
     * @param string $githubUsername
     * @param RoomRepo $roomRepo
     * @param string $branchName
     * @param string $githubPrivateToken
     * @return mixed
     */
    public function handle(string $githubUsername, RoomRepo $roomRepo, string $branchName, string $githubPrivateToken): mixed
    {
        // First, get the SHA of the base branch
        $sha = GetBranchSha::run($roomRepo->owner, $roomRepo->repository, \Str::slug($branchName), $githubPrivateToken);

        // Create the new branch based on the task base branch's SHA
        return CreateBranch::run($githubUsername, $roomRepo->repository, \Str::slug($branchName), $githubPrivateToken, $sha);
    }
}
