<?php

namespace App\Actions\Rooms;

use App\Actions\Github\CreateBranch;
use App\Actions\Github\GetBranchSha;
use App\Models\Task;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateRoomBranch
{
    use AsAction;


    /**
     * @param Task $task
     * @param string $githubPrivateToken
     * @return mixed
     */
    public function handle(Task $task, string $githubPrivateToken): mixed
    {
        $roomRepo = $task->room->repository;

        // First, get the SHA of the base branch
        $sha = GetBranchSha::run($roomRepo->owner, $roomRepo->repository, $roomRepo->branch, $githubPrivateToken);

        // Create the new branch based on the Room base branch's SHA
        $response = CreateBranch::run($roomRepo->owner, $roomRepo->repository, $task->title, $githubPrivateToken, $sha);

        return $response->json();
    }
}
