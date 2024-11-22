<?php

namespace App\Actions\Rooms;

use App\Actions\Repositories\StoreRepository;
use App\Models\Room;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreRoom
{
    use AsAction;

    public function handle($data, $timeZone): Room
    {
        $room = Room::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'manager_id' => Auth::id(),
            'start_at' => Carbon::parse($data['start_at'])->setTimezone($timeZone),
        ]);
        StoreRepository::run($room, $data);
        return $room;
    }
}
