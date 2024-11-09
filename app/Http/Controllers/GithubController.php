<?php

namespace App\Http\Controllers;

use App\Actions\Github\GetReps;
use App\Actions\Github\GetRepoBranches;
use App\Actions\Github\GetRepoPullRequests;
use Mockery\Exception;

class GithubController extends Controller
{

    public function showProjects()
    {
        try {
            return GetReps::run();
        } catch (Exception) {
            return response()->json([
                'status' => false,
                'message' => 'problem getting info from this user'
            ], 400);
        }

    }

    public function showBranches(string $repo)
    {
        try {
            return GetRepoBranches::run($repo);
        } catch (Exception) {
            return response()->json([
                'status' => false,
                'message' => 'problem getting info from this repo'
            ], 400);
        }
    }

    public function showPullRequests(string $repo, string $branch = null)
    {
        try {
            return GetRepoPullRequests::run($repo, $branch);
        } catch (Exception) {
            return response()->json([
                'status' => false,
                'message' => 'problem getting info from this repo'
            ], 400);
        }
    }
}

