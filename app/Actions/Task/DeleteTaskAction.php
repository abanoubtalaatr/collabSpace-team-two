<?php

namespace App\Actions\Task;

use App\Models\Task;
use Illuminate\Support\Facades\DB;

class DeleteTaskAction
{

    public function execute(Task $task)
    {
        DB::beginTransaction();
        try {
        $task->teams()->detach();
            $task->attachments()->detach();
            $task->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        
        }
    }
}
