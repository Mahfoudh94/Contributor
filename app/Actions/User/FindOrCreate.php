<?php

namespace App\Actions\User;

use App\Models\LinkedSocialAccount;
use App\Models\User;
use Laravel\Socialite\Two\User as ProviderUser;
use Lorisleiva\Actions\Concerns\AsAction;

class FindOrCreate
{
    use AsAction;

    public function handle(ProviderUser $providerUser, string $provider)
    {
        $linkedSocialAccount = LinkedSocialAccount::query()->where('provider_name', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();

        if ($linkedSocialAccount) {
            return $linkedSocialAccount->user;
        } else {
            $user = null;

            if ($email = $providerUser->getEmail()) {
                $user = User::query()->where('email', $email)->first();
            }

            if (!$user) {
                $user = User::query()->create([
                    'name' => $providerUser->getRaw()['login'],
                    'email' => $providerUser->getEmail(),
                ]);
                $user->markEmailAsVerified();
            }

            $user->linkedSocialAccounts()->create([
                'provider_id' => $providerUser->getId(),
                'provider_name' => $provider,
            ]);

            return $user;
        }
    }
}
