<?php

namespace App\Actions\Tasks;

use App\Models\Room;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreTask
{
    use AsAction;

    public function handle($data): void
    {
        Room::findOrFail($data['roomId'])->tasks()->create([
                'title' => $data['title'],
                'description' => $data['description'],
                'start_at' => date($data['start_at'])
            ]);
    }
}
