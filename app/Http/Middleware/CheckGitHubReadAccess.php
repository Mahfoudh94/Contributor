<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckGitHubReadAccess
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

        if (!$user || !$user->githubAccount?->github_token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $githubAccount = $user->githubAccount;
        $githubToken = $githubAccount->github_token;

        // Check and refresh token if necessary
        if (!$this->isTokenValid($githubToken)) {
            $githubToken = $this->refreshGitHubToken($githubAccount);
            if (!$githubToken) {
                return response()->json(['error' => 'Could not refresh GitHub token'], 401);
            }
            // Update the token in the database
            $githubAccount->github_token = $githubToken;
            $githubAccount->save();
        }

        // Attach the valid token to the request for use in controllers
        $request->attributes->set('github_token', $githubToken);

        return $next($request);
    }

    /**
     * Check if GitHub token is valid.
     */
    protected function isTokenValid(string $token): bool
    {
        try {
            $response = $this->client->get('https://api.github.com/user', [
                'headers' => [
                    'Authorization' => 'token ' . $token,
                    'Accept' => 'application/vnd.github.v3+json',
                ],
            ]);

            return $response->getStatusCode() === 200;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Refresh GitHub token.
     *
     * @throws GuzzleException
     */
    protected function refreshGitHubToken($githubAccount): ?string
    {
        $response = $this->client->post('https://github.com/login/oauth/access_token', [
            'form_params' => [
                'client_id' => config('services.github.client_id'),
                'client_secret' => config('services.github.client_secret'),
                'refresh_token' => $githubAccount->github_refresh_token,
                'grant_type' => 'refresh_token',
            ],
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        if (isset($data['access_token'])) {
            // Update both tokens in the database
            $githubAccount->update([
                'github_token' => $data['access_token'],
                'github_refresh_token' => $data['refresh_token'] ?? $githubAccount->github_refresh_token,
            ]);

            return $data['access_token'];
        }

        return null;
    }
}
