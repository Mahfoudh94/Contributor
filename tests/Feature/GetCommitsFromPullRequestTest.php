<?php

namespace Tests\Feature;

use App\Actions\Github\GetCommitsFromPullRequest;
use App\Http\Controllers\GithubController;
use App\Http\Requests\GetCommitsRequest;
use App\Http\Resources\CommitResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Mockery;

use Tests\TestCase;

class GetCommitsFromPullRequestTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        Route::post('test/{repo}/pull-requests/{pr_id}/commits', [GithubController::class, 'showCommits']);
    }

    public function test_api_return_data(): void
    {
        $owner = "your-owner";
        $repo = "your-repo";
        $pullNumber = "your-pull-number";
        $url = "https://api.github.com/repos/{$owner}/{$repo}/pulls/{$pullNumber}/commits";
        $body = file_get_contents(base_path("tests/Fixtures/commitsFromPullRequest.json"));

        Http::fake([
            $url => Http::response($body, 200),
        ]);

        $this->assertTrue(Http::get($url)->ok());
        $this->assertEquals(json_decode($body, true), Http::get($url)->json());
    }

    public function test_api_on_error_return_empty_response(): void
    {
        $owner = "your-owner";
        $repo = "your-repo";
        $pullNumber = "your-pull-number";
        $url = "https://api.github.com/repos/{$owner}/{$repo}/pulls/{$pullNumber}/commits";
        $this->assertFalse(Http::get($url)->ok());

    }

    public function test_action_return_response(): void
    {
        $owner = "your-owner";
        $repo = "your-repo";
        $pullNumber = "your-pull-number";
        $url = "https://api.github.com/repos/{$owner}/{$repo}/pulls/{$pullNumber}/commits";
        $body = json_encode(file_get_contents(base_path("tests/Fixtures/commitsFromPullRequest.json")));

        $user = Mockery::mock(User::class);
        $user->shouldReceive('getAttribute')->with('github_token')->andReturn('github_token');
        $this->actingAs($user);

        Http::fake([
            $url => Http::response($body, 200),
        ]);

        $expectedResource = CommitResource::collection(collect(json_decode($body, true)));
        $this->assertEquals(GetCommitsFromPullRequest::run($owner, $repo, $pullNumber), $expectedResource);
    }

    public function test_action_on_url_error_throw_exception(): void
    {
        $this->expectExceptionCode(\Exception::class);
        $this->expectExceptionMessage("Failed to retrieve commits from GitHub API");
        $this->expectExceptionCode(400);

        $owner = "your-owner";
        $repo = "your-repo";
        $pullNumber = "your-pull-number";

        $user = Mockery::mock(User::class);
        $user->shouldReceive('getAttribute')->with('github_token')->andReturn('github_token');
        $this->actingAs($user);

        GetCommitsFromPullRequest::run($owner, $repo, $pullNumber);

    }


    public function test_show_commits_route_with_mocked_middleware()
    {
        $this->withoutExceptionHandling();

        $owner = "your-owner";
        $repo = "your-repo";
        $pullNumber = "your-pull-number";
        $url = "https://api.github.com/repos/{$owner}/{$repo}/pulls/{$pullNumber}/commits";
        $body = json_encode(file_get_contents(base_path("tests/Fixtures/commitsFromPullRequest.json")));

        $user = Mockery::mock(User::class);
        $user->shouldReceive('getAttribute')->with('github_token')->andReturn('github_token');
        $this->actingAs($user);

        $mockRequest = \Mockery::mock(GetCommitsRequest::class);

        $mockRequest->shouldReceive('validated')->andReturn([
            'owner_id' => $owner,  // Provide valid data
        ]);

        $mockRequest->shouldReceive('input')
            ->with('owner_id')
            ->andReturn($owner);

        // Bind the mock to the service container
        $this->app->instance(GetCommitsRequest::class, $mockRequest);

        Http::fake([
            $url => Http::response($body, 200),
        ]);

        $expectedResource = CommitResource::collection(collect(json_decode($body, true)));

        // Perform a GET request to the route
        $response = $this->postJson("test/{$repo}/pull-requests/{$pullNumber}/commits",[
        'owner_id' => $owner,
        ]);

        // Verify the response status
        $response->assertStatus(200);
    }
}
