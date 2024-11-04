<?php

namespace App\Actions\User;

use Exception;
use Laravel\Socialite\Facades\Socialite;
use Lorisleiva\Actions\Concerns\AsAction;

class Login
{
    use AsAction;

    /**
     * @throws Exception
     */
    public function handle($accessToken, $provider): array
    {
        $providerUser = Socialite::driver($provider)->userFromToken($accessToken);

        if (filled($providerUser)) {
            $user = FindOrCreate::run($providerUser, $provider);
        } else {
            $user = $providerUser;
        }
        auth()->login($user);
        if (auth()->check()) {
            return [
                'token' => auth()->user()->createToken('API Token')->plainTextToken
            ];
        } else {
            throw new Exception('Failed to Login try again');
        }
    }
}
