<?php

namespace App\Actions\Tasks;

use App\Models\Task;
use Illuminate\Support\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateTask
{
    use AsAction;

    public function handle(Task $task, $data): void
    {
        $task->fill(array_filter([
            'title' => $data['title'],
            'description' => $data['description'],
            'start_at' => Carbon::parse($data['start_at'])
        ]));
    }
}
