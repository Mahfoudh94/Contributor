<?php

namespace App\Actions\Github;

use Exception;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class ValidateGithubToken
{
    use AsAction;

    /**
     * Validate if the provided GitHub token is valid.
     *
     * @param string $token
     * @return bool
     */
    public function handle(string $token): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'token ' . $token,
                'Accept' => 'application/vnd.github.v3+json',
            ])->get('https://api.github.com/user');

            return $response->status() === 200;
        } catch (Exception) {
            return false;
        }
    }
}
