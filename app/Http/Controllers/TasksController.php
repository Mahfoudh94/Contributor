<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::paginate(10);
        return Inertia::render('', [
            'tasks' => $tasks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return Inertia::render('');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'start_at' => 'sometimes|date|after:now'
        ]);
        Task::create([
            'title' => $request->string('title'),
            'description' => $request->string('description'),
            'manager_id' => $request->user()->id,
            'start_at' => $request->date('start_at')
        ]);
        return \Redirect::to('/');
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
    public function update(Request $request, string $id)
    {
        Task::find($id)->fill(
            array_filter([
                'title' => $request->string('title'),
                'description' => $request->string('description'),
                'start_at' => $request->date('start_at')
            ])
        );
        return \Redirect::to('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Task::find($id)->delete();
        return \Redirect::to('/')
            ->with([
                'success' => 'deleted successfully'
            ]);
    }
}
