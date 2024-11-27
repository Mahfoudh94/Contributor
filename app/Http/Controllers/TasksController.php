<?php

namespace App\Http\Controllers;

use App\Actions\Tasks\DeleteTask;
use App\Actions\Tasks\GetPaginatedTasks;
use App\Actions\Tasks\JoinTask;
use App\Actions\Tasks\StartTask;
use App\Actions\Tasks\StoreTask;
use App\Actions\Tasks\UpdateTask;
use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Models\Room;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('', [
            'tasks' => GetPaginatedTasks::run()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $validatedData = $request->validated();

        $room = Room::find($validatedData['roomId']);
        if (!$room) {
            return Redirect::back()->with('error', 'Room not found.');
        }

        StoreTask::run($room, $validatedData);
        return Redirect::back()->with('message', 'Task created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return Redirect::back()->with('error', 'Task not found.');
        }
        return Inertia::render('', [
            'task' => $task
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return Redirect::back()->with('error', 'Task not found.');
        }
        return Inertia::render('', [
            'task' => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return Redirect::back()->with('error', 'Task not found.');
        }
        UpdateTask::run($task, $request->validated());
        return Redirect::back()->with('success', 'Task updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return Redirect::back()->with('error', 'Task not found.');
        }
        DeleteTask::run($task);
        return Redirect::back()->with([
            'success' => 'deleted successfully'
        ]);
    }

    /**
     * Start the task manually.
     */
    public function start(Request $request, string $id)
    {
        $githubPrivateToken = $request->attributes->get('github_private_token');

        $task = Task::find($id);

        if (!$task) {
            return Redirect::back()->with('error', 'Task not found.');
        }

        // Invoke the action to start the task
        StartTask::run($task, $githubPrivateToken);

        return Redirect::back()->with('success', 'task started');
    }

    /**
     * Join the task manually.
     */
    public function joinTask(Request $request, string $id)
    {
        $githubPrivateToken = $request->attributes->get('github_private_token');

        $task = Task::find($id);

        if (!$task) {
            return Redirect::back()->with('error', 'Task not found.');
        }

        // Invoke the action to start the task
        JoinTask::run($task, auth()->user(), $githubPrivateToken);

        return Redirect::back()->with('success', 'task joined successfully');
    }
}
