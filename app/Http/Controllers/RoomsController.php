<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Carbon\Carbon;
use Carbon\Unit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::paginate(10);
        return Inertia::render('', [
            'rooms' => $rooms
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
        Room::create([
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
            'room' => Room::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('', [
            'room' => Room::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Room::find($id)->fill(
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
        Room::find($id)->delete();
        return \Redirect::to('/')
            ->with([
                'success' => 'deleted successfully'
            ]);
    }
}
