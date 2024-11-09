<?php

namespace App\Actions\User\auth\github;

use App\Models\LinkedSocialAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Two\User as ProviderUser;
use Lorisleiva\Actions\Concerns\AsAction;

class FindOrCreateGithub
{
    use AsAction;

    public function handle(ProviderUser $providerUser)
    {
        $linkedSocialAccount = LinkedSocialAccount::query()->where('provider_name', 'github')
            ->where('provider_id', $providerUser->getId())
            ->first();

        if ($linkedSocialAccount) {
            return $linkedSocialAccount->user;
        } else {
            $user = null;

            if ($email = $providerUser->getEmail()) {
                $user = User::query()->where('email', $email)->first();
            }

            if(!$user){
                $user = Auth::user();
            }

            if (!$user) {
                $user = User::query()->create([
                    'name' => $providerUser->getRaw()['login'],
                    'email' => $providerUser->getEmail(),
                ]);
                $user->markEmailAsVerified();
            }

            return $user;
        }
    }
}
