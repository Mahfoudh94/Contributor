<?php

namespace App\Actions\Tasks;

use App\Actions\Rooms\CreateRoomBranch;
use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Lorisleiva\Actions\Concerns\AsAction;

class StartTask
{
    use AsAction;

    /**
     * Start the task
     *
     * @param Task $task The task to start.
     * @param string $githubPrivateToken GitHub write access token.
     * @return Task The updated task.
     */
    public function handle(Task $task, string $githubPrivateToken): Task
    {
        CreateRoomBranch::run($task, $githubPrivateToken);
        //$task->start_at ??= Carbon::now();
        $task->status = TaskStatusEnum::Active;  // Update status to Active
        $task->save(); // Persist changes to the database

        return $task;
    }
}
