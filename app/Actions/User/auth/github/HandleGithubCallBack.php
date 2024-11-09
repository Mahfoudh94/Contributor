<?php

namespace App\Actions\User\auth\github;

use App\Actions\SocialAccount\FindGithubLinkedSocialAccount;
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
        $providerUser = Socialite::driver('github')->stateless()->user();

        // Attempt to find a linked social account
        $linkedSocialAccount = FindGithubLinkedSocialAccount::run($providerUser);

        // If a linked social account is found, retrieve the user
        if ($linkedSocialAccount) {
            $user = $linkedSocialAccount->user;
        } else {
            $user = HandleGithubProviderUser::run($providerUser);
        }

        // Attempt to log in the user
        Auth::login($user);

        // Confirm successful login
        if (auth()->check()) {
            return $user;
        }

        throw new Exception('Failed to Login. Try again.');
    }
}
