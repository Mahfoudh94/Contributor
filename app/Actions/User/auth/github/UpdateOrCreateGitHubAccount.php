<?php

namespace App\Actions\User\auth\github;

use App\Models\User;

use Laravel\Socialite\Two\User as ProviderUser;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateOrCreateGitHubAccount
{
    use AsAction;

    public function handle(User $user, ProviderUser $providerUser): void
    {
        // Check if the GitHub account record already exists
        $githubAccount = $user->githubAccount()->first();

        // Prepare only the fields we want to update
        $updateData = [
            'github_token' => $providerUser->token,
            'github_refresh_token' => $providerUser->refreshToken,
        ];

        // Conditionally add account_id and account_name if they don't exist
        if (!$githubAccount || !$githubAccount->account_id) {
            $updateData['account_id'] = $providerUser->getId();
        }

        if (!$githubAccount || !$githubAccount->account_name) {
            $updateData['account_name'] = $providerUser->getRaw()['login'];;
        }

        // Update or create the GitHub account with the conditional fields
        $user->githubAccount()->updateOrCreate(
            ['user_id' => $user->id],
            $updateData
        );
    }
}
