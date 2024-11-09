<?php

namespace App\Actions\SocialAccount;

use App\Models\User;
use Laravel\Socialite\Two\User as ProviderUser;
use Lorisleiva\Actions\Concerns\AsAction;

class LinkGithubSocialAccount
{
    use AsAction;

    public function handle(User $user, ProviderUser $providerUser): void
    {
        $user->linkedSocialAccounts()->updateOrCreate([
            'provider_id' => $providerUser->getId(),
            'provider_name' => 'github',
        ]);
    }
}
