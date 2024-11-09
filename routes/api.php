<?php

use App\Http\Controllers\Api\v1\SocialLoginController;
use App\Http\Controllers\Api\v1\GitHubController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/social_login', [SocialLoginController::class, 'login']);

    // Define the API prefix for GitHub routes
    Route::prefix('github')->middleware('auth:sanctum')->group(function () {

        // Retrieve Projects
        Route::get('/projects', [GitHubController::class, 'getProjects']);

        // Retrieve Branches from a Selected Repository
        Route::get('/{repo}/branches', [GitHubController::class, 'getBranches']);

        // Create a Branch Based on the Selected Branch
        Route::post('/{repo}/branches', [GitHubController::class, 'createBranch']);

        // Create a Fork from the Selected Repository
        Route::post('/{repo}/fork', [GitHubController::class, 'createFork']);

        // Check if a Fork Already Exists on the Developer’s Account
        Route::get('/{repo}/fork/check', [GitHubController::class, 'checkForkExists']);

        // Retrieve Pull Requests, Filtering by Branch
        Route::get('/{repo}/pull-requests', [GitHubController::class, 'getPullRequests']);

        // Retrieve Commits from a Specific Pull Request
        Route::get('/{repo}/pull-requests/{pr_id}/commits', [GitHubController::class, 'getCommits']);
    });
});
