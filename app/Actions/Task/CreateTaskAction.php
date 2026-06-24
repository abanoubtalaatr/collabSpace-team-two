<?php

namespace App\Actions\Task;

use App\Http\Requests\Api\StoreTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class CreateTaskAction
{
    public function execute(Project $project, StoreTaskRequest $request)
    {
        $validated = $request->validated(); 

        DB::beginTransaction(); 
        try {
            $task = Task::create([
                'project_id' => $project->id,
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
                'priority' => $request->priority,
                'created_by' => $request->user()->id,
            ]);
            // assign to the team 
            if ($request->has('teams')) {
                $task->teams()->attach($request->input('teams'));
            }

            DB::commit(); 

            return $task; 

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
