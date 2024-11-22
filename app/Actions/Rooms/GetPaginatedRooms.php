<?php

namespace App\Actions\Rooms;

use App\Models\Room;
use Illuminate\Pagination\LengthAwarePaginator;
use LaravelIdea\Helper\App\Models\_IH_Room_C;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPaginatedRooms
{
    use AsAction;

    public function handle(int $perPage = 10): array|LengthAwarePaginator|_IH_Room_C
    {
       return Room::with(['tasks:id,room_id,status', 'manager:id,name'])
            ->orderByDesc('start_at')
            ->orderByDesc('updated_at')
            ->paginate($perPage);
    }
}
