<?php

namespace App\Http\Requests\Api\V1\Task;

use App\Enums\ApplicantDesired;
use App\Enums\AssociateCategories;
use App\Enums\InstituteType;
use App\Enums\TaskStatus;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends BaseTaskRequest
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

            'status' => [
                'required',
                Rule::enum(TaskStatus::class)
            ],
            'remark' => [
                'nullable',
                'string',
            ]
        ];
    }

}
