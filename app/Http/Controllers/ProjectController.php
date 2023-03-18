<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $projects = Project::
            when($request->has('customer_id'), fn($q) => $q->where('customer_id', $request->input('customer_id')))
            ->when($request->has('project_manager_id'), fn($q) => $q->where('project_manager_id', $request->input('project_manager_id')))
            ->get();
        return response()->json($projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $project = new Project($request->only(['title', 'description', 'customer_id']));
        $project = auth()->user()->projects()->save($project);
        return response()->json($project);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return response()->json($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->only(['title', 'description']));
        return response()->json($project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        return null;
    }
}
