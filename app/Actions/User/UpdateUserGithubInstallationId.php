<?php

namespace App\Actions\User;

use Auth;
use Exception;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateUserGithubInstallationId
{
    use AsAction;

    /**
     * @throws Exception
     */
    public function handle(string $installation_id): void
    {
        Auth::user()->githubAccount()
            ->update(['installation_id' => $installation_id]);
    }
}
