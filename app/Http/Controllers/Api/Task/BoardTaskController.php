<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\TaskStatus;
use App\Models\Task;
use App\Trait\ApiResponse;

class BoardTaskController extends Controller
{
    use ApiResponse;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
            $grouped = [];
        foreach (TaskStatus::cases() as $status) {
            $pageName = "{$status->value}_page"; // e.g. completed_page
            $grouped[$status->value] = Task::query()
                ->where('status', $status->value)
                ->latest()
                ->paginate(10, ['*'], $pageName);
        }


        return $this->successResponse($grouped, 'Tasks fetched successfully');
    }
}
