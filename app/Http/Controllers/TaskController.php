<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Carbon\Carbon;

class TaskController extends Controller
{

    public function kanban()
    {
        return view('tasks.index');
    }

    public function statistic()
    {
        return view('tasks.statistic');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return \App\Models\Phase::with('tasks.user')->withCount('tasks')->get();
    }

    /**
     * Display a listing of the Users resource.
     */
    public function users()
    {
        return \App\Models\User::all();
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
    public function store(StoreTaskRequest $request)
    {
        // Create a new task from the $request
        $task = Task::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        // Update a existing task from the $request
        $task = Task::findOrFail($request->id);

        $task->name = $request->name;
        $task->phase_id = $request->phase_id;
        $task->user_id = $request->user_id;

        $phase = $task->phase;
        if ($phase->completed && !$task->completed_at) {
            $task->completed_at = Carbon::now();
        }

        $task->save();

        return response()->json('Task updated successfully!');
    }

    /**
     * Get tasks that assigned to user
     */
    public function getUserTasks(Request $request)
    {
        $tasks = Task::where('user_id', $request->user_id)->with('user')->get();

        return $tasks;
    }

    /**
     * Get tasks completed this week
     */
    public function getCompletedTasksThisWeek() {
        $tasks = Task::whereBetween('completed_at', [Carbon::now()->subWeek()->format("Y-m-d H:i:s"), Carbon::now()])->with('user')->get();

        return $tasks;
    }

    /**
     * Get tasks completed this month
     */
    public function getCompletedTasksThisMonth() {
        $tasks = Task::whereMonth('completed_at', Carbon::now()->month)->with('user')->get();

        return $tasks;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Task::destroy($task->id);
    }
}
