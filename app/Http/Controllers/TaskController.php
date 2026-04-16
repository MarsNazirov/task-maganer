<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Cache::remember('tasks', 90, function () {
            return Task::orderBy('date', 'desc')->get();
        });

        return view('tasks.index', [
            'tasks' => $tasks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        Task::create($data);

        if (Cache::has('tasks')) {
            Cache::forget('tasks');
        }

        return redirect()->route('tasks.index');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', [
            'task' => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Task $task)
    {
        $data = $request->validated();

        $task->update($data);

        if (Cache::has('tasks')) {
            Cache::forget('tasks');
        }

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        if (Cache::has('tasks')) {
            Cache::forget('tasks');
        }

        return response()->json(['success' => true]);
    }

    public function toggle(Task $task) 
    {
        $task->completed = !$task->completed;
        $task->save();

        if (Cache::has('tasks')) {
            Cache::forget('tasks');
        }

        return response()->json(['success' => true, 'completed' => $task->completed]);
    }
}
