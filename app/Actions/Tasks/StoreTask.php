<?php

namespace App\Actions\Tasks;

use App\Models\Room;
use Illuminate\Support\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreTask
{
    use AsAction;

    public function handle(Room $room, $data): void
    {
        $room->tasks()->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'start_at' => Carbon::parse($data['start_at'])
        ]);
    }
}
