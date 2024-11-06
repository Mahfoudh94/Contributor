<?php

namespace App\Actions\User;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Lorisleiva\Actions\Concerns\AsAction;

class RedirectToGithub
{
    use AsAction;

    public function handle()
    {
        return Socialite::driver('github')->redirect();
    }

    public function asController(Request $request)
    {
        return $this->handle();
    }
}
