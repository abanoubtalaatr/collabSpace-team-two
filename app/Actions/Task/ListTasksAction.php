<?php

namespace App\Actions\Task;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Http\Request;

class ListTasksAction
{
    public function execute(Request $request, int $perPage = 10, int $page = 1) 
    {

        $status = $request->enum('status', TaskStatus::class);
        $query = Task::query()->latest(); 

        if ($status) {
            $query->where('status', $status); 
        }

        if ($request->has('project_id')) {
            $query->where('project_id', $request->input('project_id'));
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->has('sort')) {
            $query->orderBy($request->input('sort'), $request->input('order', 'asc'));
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->paginate($perPage, ['*'], 'page', $page)->appends($request->query()); 
    }
}
