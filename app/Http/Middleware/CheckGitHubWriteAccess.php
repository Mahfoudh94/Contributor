<?php

namespace App\Http\Middleware;

use App\Actions\User\auth\github\RedirectToGithubInstall;
use Closure;
use Exception;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckGitHubWriteAccess
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws GuzzleException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 400);
        }

        $githubAccount = $user->githubAccount;

        // Check if the user has an installation_id
        if (!$githubAccount || !$githubAccount->installation_id) {
            $installationId = $this->getOrCreateInstallationId($githubAccount);

            if (!$installationId) {
                // Redirect the user to install the GitHub App if not installed
                return RedirectToGithubInstall::run();
            }
            // Save the retrieved installation_id to the user's account
            $githubAccount->installation_id = $installationId;
            $githubAccount->save();
        }

        // Retrieve a new installation token based on the installation_id
        $installationToken = $this->getInstallationToken($githubAccount->installation_id);
        if (!$installationToken) {
            return response()->json(['error' => 'Could not obtain GitHub installation token'], 400);
        }

        // Attach the valid token to the request for use in controllers
        $request->attributes->set('github_installation_token', $installationToken);

        return $next($request);
    }

    /**
     * Attempt to retrieve the GitHub App installation ID for the user.
     *
     * @param $githubAccount
     * @return string|null
     * @throws GuzzleException
     */
    protected function getOrCreateInstallationId($githubAccount): ?string
    {
        try {
            $jwt = $this->generateJWT();

            // Get installations for the authenticated app
            $response = $this->client->get('https://api.github.com/app/installations', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwt,
                    'Accept' => 'application/vnd.github.v3+json',
                ],
            ]);

            $installations = json_decode($response->getBody(), true);

            // Find the user's installation ID, if it exists
            foreach ($installations as $installation) {
                if ($installation['account']['id'] == $githubAccount->github_user_id) {
                    return $installation['id'];
                }
            }

            return null;
        } catch (Exception) {
            return null;
        }
    }

    /**
     * Obtain a GitHub installation token.
     *
     * @throws GuzzleException
     */
    protected function getInstallationToken(string $installationId): ?string
    {
        try {
            $jwt = $this->generateJWT();

            $response = $this->client->post("https://api.github.com/app/installations/{$installationId}/access_tokens", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwt,
                    'Accept' => 'application/vnd.github.v3+json',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            return $data['token'] ?? null;
        } catch (Exception) {
            return null;
        }
    }

    /**
     * Generate a JSON Web Token (JWT) for GitHub App authentication.
     */
    protected function generateJWT(): string
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
