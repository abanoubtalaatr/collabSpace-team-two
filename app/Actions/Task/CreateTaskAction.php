<?php

namespace App\Actions\Task;

use App\Http\Requests\Api\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class CreateTaskAction
{
    public function execute(StoreTaskRequest $request)
    {
        $validated = $request->validated(); 

        DB::beginTransaction(); 
        try {
            $task = Task::create([
                'project_id' => $validated['project_id'],
                'name' => $validated['name'],
                'description' => $validated['description'],
                'status' => $validated['status'],
                'priority' => $validated['priority'],
                'created_by' => $request->user()->id,
            ]);
            // assign to the team 
            if (isset($validated['teams'])) {
                $task->teams()->attach($validated['teams']);
            }

            // upload the attachements 
            if (isset($validated['attachments'])) {
                // TODO: Call the file service to upload the attachement in the fle table 
                // TODO: Attach the file to the task 
            }

            DB::commit(); 

            return $task; 

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
