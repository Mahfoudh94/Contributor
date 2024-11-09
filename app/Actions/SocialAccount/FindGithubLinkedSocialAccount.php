<?php

namespace App\Actions\SocialAccount;

use App\Models\LinkedSocialAccount;
use Lorisleiva\Actions\Concerns\AsAction;
use Laravel\Socialite\Two\User as ProviderUser;

class FindGithubLinkedSocialAccount
{
    use AsAction;

    public function handle(ProviderUser $providerUser)
    {
        return LinkedSocialAccount::query()
            ->where('provider_name', 'github')
            ->where('provider_id', $providerUser->getId())
            ->first();
    }
}
