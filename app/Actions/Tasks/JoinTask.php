<?php

namespace App\Actions\Tasks;

use App\Actions\Github\CheckBranchExists;
use App\Actions\Github\CheckForkExists;
use App\Actions\Github\CreateFork;
use App\Models\Task;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class JoinTask
{
    use AsAction;

    /**
     * @param Task $task
     * @param User $user
     * @param string $githubPrivateToken
     * @return Task
     */
    public function handle(Task $task, User $user, string $githubPrivateToken): Task
    {
        $roomRepo = $task->room->repository;
        $userGithubAccount = $user->githubAccount;

        // Ensure the user is not already assigned to the task
        if (!$task->users->contains($user)) {
            if (!CheckForkExists::run($userGithubAccount->account_name, $roomRepo->repository, $githubPrivateToken)) {
                CreateFork::run($userGithubAccount->account_name, $roomRepo->repository, $githubPrivateToken);
            }
            if (!CheckBranchExists::run($userGithubAccount->account_name, $roomRepo->repository, $task->title, $githubPrivateToken)) {
                CreateTaskBranch::run($userGithubAccount->account_name, $roomRepo, $task->title, $githubPrivateToken);
            }
            $task->users()->attach($user);
        }

        return $task;
    }
}
