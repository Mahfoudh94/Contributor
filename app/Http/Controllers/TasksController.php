<?php

namespace App\Http\Controllers;

use App\Actions\Tasks\DeleteTask;
use App\Actions\Tasks\GetPaginatedTasks;
use App\Actions\Tasks\StoreTask;
use App\Actions\Tasks\UpdateTask;
use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Models\Task;
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
        StoreTask::run($request->validated());
        return Redirect::back()->with('message', 'Task created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('', [
            'task' => Task::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('', [
            'task' => Task::findOrFail($id)
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
}
