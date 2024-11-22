<?php

namespace App\Actions\Tasks;

use App\Models\Task;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class JoinTask
{
    use AsAction;

    public function handle(Task $task, User $user)
    {
        // Ensure the user is not already assigned to the task
        if (!$task->users->contains($user)) {
            $task->users()->attach($user);
        }

        return $task;
    }
}
