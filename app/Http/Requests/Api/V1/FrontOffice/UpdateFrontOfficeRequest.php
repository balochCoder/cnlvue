<?php

namespace App\Http\Requests\Api\V1\FrontOffice;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateFrontOfficeRequest extends BaseFrontOfficeRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'branchId' => ['required', 'exists:branches,id'],
            'name' => ['required', 'string'],
            'phone' => ['nullable'],
            'mobile' => ['nullable'],
            'editLeads' => ['nullable', 'boolean'],
            'email' => ['sometimes', 'email', Rule::unique('users', 'email')->ignore($this->userId)],
            'password' => ['sometimes', 'nullable', 'string'],
            'passwordConfirmation' => ['sometimes', 'same:password'],
            'userId' => ['required', 'integer', 'exists:users,id'],
        ];
    }

}
