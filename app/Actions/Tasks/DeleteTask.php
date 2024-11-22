<?php

namespace App\Actions\Tasks;

use App\Models\Task;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteTask
{
    use AsAction;

    public function handle(Task $task): void
    {
        $task->delete();
    }
}
