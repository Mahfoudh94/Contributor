<?php

namespace App\Actions\User;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Lorisleiva\Actions\Concerns\AsAction;

class Login
{
    use AsAction;

    /**
     * @throws Exception
     */
    public function handle($accessToken, $provider): User
    {
        $providerUser = Socialite::driver($provider)->userFromToken($accessToken);

        if (filled($providerUser)) {
            $user = FindOrCreate::run($providerUser, $provider);
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
