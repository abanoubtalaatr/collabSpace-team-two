<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Trait\ApiResponse;

use App\Http\Requests\Api\CreateProjectRequest;
use App\Http\Requests\Api\UpdateProjectRequest;

use App\Actions\Project\CreateProjectAction;
use App\Actions\Project\UpdateProjectAction;
use App\Actions\Project\ListProjectsAction;
use App\Actions\Project\ShowProjectAction;
use App\Actions\Project\DeleteProjectAction;

class ProjectController extends Controller
{
    use ApiResponse;
    
    
    public function __construct(
        protected CreateProjectAction $createProject,
        protected UpdateProjectAction $updateProject,
        protected ListProjectsAction $listProjects,
        protected ShowProjectAction $showProject,
        protected DeleteProjectAction $deleteProject,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->listProjects->execute();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProjectRequest $request) 
    {
        // $this->authorize('create', Project::class);
        $project = $this->createProject->execute($request->validated());

        return $this->successResponse($project, 'Project created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project) 
    {
        $projectData = $this->showProject->execute($project);
        return $this->successResponse($projectData, 'Project retrieved successfully', 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $projectData = $this->updateProject->execute($request->validated(), $project);
        return $this->successResponse($projectData, 'Project updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->deleteProject->execute($project); 


        return $this->successResponse(null, 'Project deleted successfully', 200);
    }
}
