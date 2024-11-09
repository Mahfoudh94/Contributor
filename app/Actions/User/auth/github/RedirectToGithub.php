<?php

namespace App\Actions\User\auth\github;

use Laravel\Socialite\Facades\Socialite;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RedirectToGithub
{
    use AsAction;

    public function handle(): RedirectResponse
    {
        return Socialite::driver('github')->stateless()->redirect();
    }

}
