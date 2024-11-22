<?php

namespace App\Actions\Rooms;

use App\Models\Room;
use Illuminate\Support\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateRoom
{
    use AsAction;

    public function handle(Room $room, $data): void
    {
        $room->fill(array_filter([
            'title' => $data['title'],
            'description' => $data['description'],
            'start_at' => Carbon::parse($data['start_at'])
        ]));
    }
}