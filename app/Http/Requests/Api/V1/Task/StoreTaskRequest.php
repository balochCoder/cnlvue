<?php

namespace App\Http\Requests\Api\V1\Task;

use App\Enums\AssociateCategories;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends BaseTaskRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'=> ['required', 'string'],
            'assignedTo' => ['required', 'exists:users,id'],
            'startDate' => ['required', 'date'],
            'dueDate' => ['required', 'date', 'after_or_equal:startDate'],
            'file' => ['nullable', 'file'],
            'description' => ['required', 'string'],
        ];
    }


}
