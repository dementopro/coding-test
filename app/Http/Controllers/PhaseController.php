<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\StorePhaseRequest;
use App\Http\Requests\UpdatePhaseRequest;
use App\Models\Phase;
use App\Models\Task;

class PhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePhaseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Phase $phase)
    {
        return $phase->load('tasks.user')->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Phase $phase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePhaseRequest $request, Phase $phase)
    {
        //
    }

    /**
     * Mark the specified phase as completed.
     */
    public function markAsCompleted(Request $request) {
        $phase = Phase::findOrFail($request->phase_id);
        $phase->completed = !$phase->completed;
        $phase->save();

        $tasks = [];
        $tasks = $phase->tasks;
        foreach($tasks as $task) {
            if (!$task->completed_at) {
                $task->completed_at = Carbon::now();
            }
            $task->save();
        }

        return response()->json('Marked phase as completed!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Phase $phase)
    {
        Phase::destroy($phase->id);

        return response()->json('Phase has been removed!');
    }
}
