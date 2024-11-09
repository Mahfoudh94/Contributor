<?php

namespace App\Actions\User\auth\github;

use App\Actions\SocialAccount\LinkGithubSocialAccount;
use Exception;
use Lorisleiva\Actions\Concerns\AsAction;
use Laravel\Socialite\Two\User as ProviderUser;
class HandleGithubProviderUser
{
    use AsAction;

    /**
     * @throws Exception
     */
    public function handle(ProviderUser $providerUser)
    {
        if (!filled($providerUser)) {
            throw new Exception('Provider user information is empty.');
        }

        // Find or create the user, then link/update the GitHub account
        $user = FindOrCreateGithub::run($providerUser);
        UpdateOrCreateGitHubAccount::run($user, $providerUser);
        LinkGithubSocialAccount::run($user, $providerUser);

        return $user;
    }
}
