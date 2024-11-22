<?php

namespace App\Actions\Rooms;

use App\Models\Room;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class JoinRoom
{
    use AsAction;

    public function handle(Room $room, User $user)
    {
        if (!$room->users->contains($user)) {
            $room->users()->attach($user);
        }
        return $room;
    }
}
