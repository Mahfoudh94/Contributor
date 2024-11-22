<?php

namespace App\Actions\Badges;

use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class AssignBadge
{
    use AsAction;

    public function handle(int $userId, int $badgeId): void
    {
        $user = User::findOrFail($userId);
        $user->badges()->attach($badgeId);
    }
}
