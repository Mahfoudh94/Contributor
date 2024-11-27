<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\GithubController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [RoomsController::class, 'index'])->name('Homepage');

Route::get('tasks/{task}', [TasksController::class, 'show'])->name('tasks.show');
Route::get('tasks', [TasksController::class, 'index'])->name('tasks.index');

Route::get('rooms/{room}', [RoomsController::class, 'show'])->name('rooms.show');
Route::get('rooms', [RoomsController::class, 'index'])->name('rooms.index');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/me', [ProfileController::class, 'show'])->name('profile.me');
    Route::get('/profile/{username}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('rooms')->group(function () {

        Route::post('', [RoomsController::class, 'store'])->name('rooms.store');
        Route::get('/create', [RoomsController::class, 'create'])->name('rooms.create');
        Route::get('/{room}/edit', [RoomsController::class, 'edit'])->name('rooms.edit');
        Route::put('/{room}', [RoomsController::class, 'update'])->name('rooms.update');
        Route::delete('/{room}', [RoomsController::class, 'destroy'])->name('rooms.destroy');
    });

    Route::prefix('tasks')->group(function () {
        Route::post('', [TasksController::class, 'store'])->name('tasks.store');
        Route::get('/create', [TasksController::class, 'create'])->name('tasks.create');
        Route::get('/{task}/edit', [TasksController::class, 'edit'])->name('tasks.edit');
        Route::put('/{task}', [TasksController::class, 'update'])->name('tasks.update');

        Route::patch('/{task}/start', [TasksController::class, 'start'])
            ->middleware('github.write')
            ->name('tasks.start');

        Route::post('/{task}/join', [TasksController::class, 'joinTask'])
            ->middleware('github.write')
            ->name('tasks.join');

        Route::delete('/{task}', [TasksController::class, 'destroy'])->name('tasks.destroy');
    });

    Route::prefix('github')->group(function () {

        Route::get('/terms', fn () => "nothing for now")->name('_tos');

        Route::middleware('github.read')->group(function (){

            // Retrieve Github Repertoires
            Route::get('/repertoires', [GithubController::class, 'showProjects']);

            // Retrieve Branches from a Selected Repository
            Route::get('/{repo}/branches', [GithubController::class, 'showBranches']);

            /*
            // Retrieve Pull Requests (for displaying pull requests in a view)
            Route::get('/{repo}/pulls', [GithubController::class, 'showPullRequests']);

            // Retrieve Pull Requests with filter the user and his original branch(for displaying pull requests in a view)
            Route::get('/{repo}/{branch}/pulls', [GithubController::class, 'showPullRequests']);

            // Check if a Fork Already Exists (display fork status in a view)
            Route::get('/{repo}/fork/check', [GithubController::class, 'showForkStatus']);

            // Retrieve Commits from a Specific Pull Request (for displaying commits of a PR)
            Route::get('/{repo}/pull-requests/{pr_id}/commits', [GithubController::class, 'showCommits']);
            */
        });

        /*// Show form to create a branch
        Route::get('/{repo}/branches/create', [GithubController::class, 'showCreateBranchForm']);

        // Create a Branch Based on the Selected Branch
        Route::post('/{repo}/branches', [GithubController::class, 'createBranch']);

        // Initiate a Fork (display fork status in a view)
        Route::post('/{repo}/fork', [GithubController::class, 'createFork']);*/

    });
});

require __DIR__.'/auth.php';
