<?php

namespace App\Actions\Tasks;

use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;
use LaravelIdea\Helper\App\Models\_IH_Task_C;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPaginatedTasks
{
    use AsAction;

    public function handle(int $perPage = 10): array|LengthAwarePaginator|_IH_Task_C
    {
        return Task::paginate($perPage);
    }
}
