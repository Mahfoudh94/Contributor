<?php

namespace App\Actions\Github;

use Firebase\JWT\JWT;
use Lorisleiva\Actions\Concerns\AsAction;

class GenerateGithubJWT
{
    use AsAction;

    public function handle(): string
    {
        $privateKey = file_get_contents(storage_path('github-app.pem'));
        $payload = [
            'iat' => time(),
            'exp' => time() + (10 * 60),
            'iss' => config('services.github.app_id'),
        ];

        return JWT::encode($payload, $privateKey, 'RS256');
    }
}
