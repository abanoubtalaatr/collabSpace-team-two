<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; 
use App\Enums\TaskStatus;
use App\Enums\TaskPriority;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $projectIdRule = in_array($this->route()->getName(), ['projects.tasks.store', 'projects.tasks.index']) ? ['nullable', 'exists:projects,id'] : ['required', 'exists:projects,id'];
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', Rule::in(TaskStatus::values())],
            'priority' => ['required', 'string', Rule::in(TaskPriority::values())],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'project_id' => $projectIdRule,
            'teams' => ['nullable', 'array'],
            'teams.*' => ['nullable', 'exists:teams,id'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx', 'max:2048'],
        ];
    }


    
}
