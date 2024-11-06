<?php

namespace App\Actions\User\auth\github;

use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Lorisleiva\Actions\Concerns\AsAction;

class HandleGithubCallBack
{
    use AsAction;

    /**
     * @throws Exception
     */
    public function handle()
    {
        $providerUser = Socialite::driver('github')->user();

        if (filled($providerUser)) {
            $user = FindOrCreateGithub::run($providerUser);
        } else {
            $user = $providerUser;
        }
        Auth::login($user);
        if (auth()->check()) {
            return $user;
        } else {
            throw new Exception('Failed to Login try again');
        }
    }
}
