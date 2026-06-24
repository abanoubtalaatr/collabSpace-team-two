<?php

namespace App\Actions\Task;

use App\Models\Project;
use App\Http\Requests\Api\StoreTaskRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\File;

class CreateProjectTaskAction
{
    public function execute(Project $project, StoreTaskRequest $request)
    {
        $validated = $request->validated(); 

        DB::beginTransaction(); 
        try {
            $task = Task::create([
                'project_id' => $project->id,
                'name' => $validated->name,
                'description' => $validated->description,
                'status' => $validated->status,
                'priority' => $validated->priority,
                'created_by' => $validated->user()->id,
            ]);
            // assign to the team 
            if ($validated->has('teams')) {
                $task->teams()->attach($validated->input('teams'));
            }

            // if has files, upload them to the storage, and store it in the files table
            //then attach it to the task_file table 
            if ($validated->hasFile('files')) {
                foreach ($validated->file('files') as $file) {
                    $path = $file->store('tasks', 'public');
                    $file = File::create([
                        'path' => $path,
                        'name' => $file->getClientOriginalName(),
                        'type' => $file->getClientOriginalExtension(),
                        'size' => $file->getSize(),
                        'user_id' => $validated->user()->id,
                    ]);
                    $task->attachments()->attach($file->id);
                }
            }

            DB::commit(); 

            return $task; 

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
