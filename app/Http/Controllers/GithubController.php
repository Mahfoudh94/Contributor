<?php

namespace App\Http\Controllers;

use App\Actions\Github\GetGithubRepositories;
use Illuminate\Http\Request;

class GithubController extends Controller
{

    public function showProjects()
    {
       return GetGithubRepositories::run();
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

