<?php

namespace App\Http\Requests\Api\Task;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\TaskStatus;

class UpdateTaskStatusRequest extends FormRequest
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
            'status' => ['required', Rule::in(TaskStatus::values())],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'The status is required',
            'status.in' => 'The status must be one of the following: ' . implode(', ', TaskStatus::values()),
        ];
    }
}
