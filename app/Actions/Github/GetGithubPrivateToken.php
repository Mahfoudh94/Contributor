<?php

namespace App\Actions\Github;

use Exception;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGithubPrivateToken
{
    use AsAction;

    public function handle(string $installationId): ?string
    {
        try {
            // Request the installation access token
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . GenerateGithubJWT::run(),
                'Accept' => 'application/vnd.github.v3+json',
            ])->post("https://api.github.com/app/installations/{$installationId}/access_tokens");

            $data = $response->json();

            return $data['token'] ?? null;
        } catch (Exception) {
            return null;
        }
    }
}
