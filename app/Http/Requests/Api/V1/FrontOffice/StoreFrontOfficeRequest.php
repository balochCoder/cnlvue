<?php

namespace App\Http\Requests\Api\V1\FrontOffice;


use Illuminate\Validation\Rule;

class StoreFrontOfficeRequest extends BaseFrontOfficeRequest
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
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'string'],
            'passwordConfirmation' => ['required', 'same:password'],
        ];
    }

}
