<?php

namespace App\Actions\Github;

use App\Models\UserGithubAccount;
use Exception;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class RefreshGithubToken
{
    use AsAction;

    /**
     * Refresh the GitHub token for a given account.
     *
     * @param UserGithubAccount $githubAccount The GitHub account model instance.
     * @return string|null The new access token or null if refreshing failed.
     */
    public function handle(UserGithubAccount $githubAccount):?string
    {
        try {
            $response = Http::asForm()->withHeaders([
                'Accept' => 'application/json',
            ])->post('https://github.com/login/oauth/access_token', [
                'client_id' => config('services.github.client_id'),
                'client_secret' => config('services.github.client_secret'),
                'refresh_token' => $githubAccount->github_refresh_token,
                'grant_type' => 'refresh_token',
            ]);

            $data = $response->json();

            if (isset($data['access_token'])) {
                // Update both tokens in the database
                $githubAccount->update([
                    'github_token' => $data['access_token'],
                    'github_refresh_token' => $data['refresh_token'] ?? $githubAccount->github_refresh_token,
                ]);

                return $data['access_token'];
            }

            return null;
        } catch (Exception) {
            return null;
        }
    }
}
