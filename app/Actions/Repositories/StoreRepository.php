<?php

namespace App\Actions\Repositories;

use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreRepository
{
    use AsAction;

    public function handle(Room $room, $data): void
    {
        $room->repository()->create([
            'repository' => $data['repository'],
            'branch' => $data['branch'],
            'owner' => Auth::user()->githubAccount->account_name,
        ]);
    }
}
