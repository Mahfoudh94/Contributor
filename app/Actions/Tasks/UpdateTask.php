<?php

namespace App\Actions\Tasks;

use App\Models\Task;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateTask
{
    use AsAction;

    public function handle(Task $task, $data): void
    {
        $task->update(array_filter([
            'title' => $data['title'],
            'description' => $data['description'],
            'start_at' => date($data['start_at'])
        ]));
    }
}
