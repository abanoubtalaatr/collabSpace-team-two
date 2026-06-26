<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trait\ApiResponse;
use App\Models\Task;

class TaskAttachmentController extends Controller
{
    use ApiResponse;

    public function index(Task $task)
    {
        return $this->successResponse(null, 'Task attachments fetched successfully');
    }

    public function store(Task $task, Request $request)
    {
        return $this->successResponse(null, 'Task attachment created successfully');
    }
}
