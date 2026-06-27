<?php

namespace App\Http\Controllers\Api;

use App\Actions\Project\CreateProjectAction;
use App\Actions\Project\DeleteProjectAction;
use App\Actions\Project\ListProjectsAction;
use App\Actions\Project\ShowProjectAction;
use App\Actions\Project\UpdateProjectAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateProjectRequest;
use App\Http\Requests\Api\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Trait\ApiResponse;

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

    public function index()
    {
        $projects = $this->listProjects->execute();

        return $this->successResponse(ProjectResource::collection($projects), 'Projects retrieved successfully', 200);
    }

    public function store(CreateProjectRequest $request)
    {
        $project = $this->createProject->execute($request);

        return $this->successResponse($project, 'Project created successfully', 201);
    }

    public function show(Project $project)
    {
        $projectData = $this->showProject->execute($project);

        return $this->successResponse($projectData, 'Project retrieved successfully', 200);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $projectData = $this->updateProject->execute($request->validated(), $project);

        return $this->successResponse($projectData, 'Project updated successfully', 200);
    }

    public function destroy(Project $project)
    {
        $this->deleteProject->execute($project);

        return $this->successResponse(null, 'Project deleted successfully', 200);
    }
}
