<?php

namespace App\Actions\Github;

use App\Models\UserGithubAccount;
use Exception;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class GetOrCreateGithubInstallationId
{
    use AsAction;

    /**
     * Get or create the installation ID for a given GitHub account.
     *
     * @param UserGithubAccount $githubAccount The GitHub account model instance.
     * @return string|null The installation ID or null if not found.
     */
    public function handle(UserGithubAccount $githubAccount):?string
    {

        try {

            // Get installations for the authenticated GitHub App
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . GenerateGithubJWT::run(),
                'Accept' => 'application/vnd.github.v3+json',
            ])->get('https://api.github.com/app/installations');

            $installations = $response->json();

            // Find the installation matching the GitHub account
            foreach ($installations as $installation) {
                if (isset($installation['account']['id']) && $installation['account']['id'] == $githubAccount->account_id) {
                    return $installation['id'];
                }
            }
            return null;
        } catch (Exception) {
            return null;
        }
    }
}
