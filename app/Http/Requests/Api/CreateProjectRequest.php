<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\ProjectStatus;
use App\Enums\ProjectPriority;
use Illuminate\Validation\Rule;

class CreateProjectRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'type' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(ProjectStatus::values())],
            'priority' => ['required', Rule::in(ProjectPriority::values())],
            'description' => ['nullable', 'string', 'max:255'],
            'users' => ['nullable', 'array'],
            'users.*' => ['exists:users,id'],
            'files' => ['nullable', 'array'],
            'files.*' => ['file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx', 'max:10240'],
        ];
    }
}
