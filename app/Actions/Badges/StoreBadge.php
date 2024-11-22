<?php

namespace App\Actions\Badges;

use App\Models\Badge;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreBadge
{
    use AsAction;

    public function handle(array $data)
    {
        return Badge::create($data);
    }
}
