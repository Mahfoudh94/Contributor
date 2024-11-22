<?php

namespace App\Actions\User\auth\github;

use Illuminate\Support\Facades\Redirect;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RedirectToGithubInstall
{
    use AsAction;

    public function handle(): RedirectResponse
    {
        $installationUrl = config('services.github.install_url');
        $callbackUrl = config('services.github.install_callback');

        $redirectUrl = $installationUrl . '?state=' . urlencode($callbackUrl);

        return Redirect::to($redirectUrl);
    }
}
