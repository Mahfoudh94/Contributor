<?php

namespace App\Actions\Rooms;

use App\Models\Room;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteRoom
{
    use AsAction;

    public function handle(Room $room): void
    {
        $room->delete();
    }
}
