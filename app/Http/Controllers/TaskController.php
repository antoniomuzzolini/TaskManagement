<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateStatusTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = Task::
            with(['project.customer', 'developer'])
            ->when($request->has('project_id'), fn($q) => $q->where('project_id', $request->input('project_id')))
            ->when($request->has('developer_id'), fn($q) => $q->where('developer_id', $request->input('developer_id')))
            ->when(
                $request->has('customer_id'), 
                fn($q) => $q->whereHas(
                    'project', 
                    fn ($q1) => $q1->where('customer_id', $request->input('customer_id'))
                )
            )
            // ->when(auth()->user()->hasRole('project manager'), fn($q) => $q->whereHas('project', fn($q1) => $q1->where('project_manager_id', auth()->user()->id)))
            ->when(auth()->user()->hasRole('developer'), fn($q) => $q->where('developer_id', auth()->user()->id))
            ->get();
        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = new Task($request->only(['title', 'description', 'project_id', 'developer_id', 'priority']));
        $task->save();
        return response()->json($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->only(['title', 'description', 'priority', 'developer_id']));
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(UpdateStatusTaskRequest $request, Task $task)
    {
        $task->update($request->only(['status']));
        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        return null;
    }
}
