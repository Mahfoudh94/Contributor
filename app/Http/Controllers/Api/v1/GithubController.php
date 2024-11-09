<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Github\GetGithubProjects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GithubController extends Controller
{
    public function getProjects()
    {
        GetGithubProjects::run();
    }

    public function showProjects()
    {
        // Code to show GitHub projects in a view
    }

    public function getBranches($repo)
    {
        // Code to get branches from a specific repository
    }

    public function showBranches($repo)
    {
        // Code to show branches in a view
    }

    // Add other methods for each route
}

