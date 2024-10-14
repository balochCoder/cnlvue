<?php

namespace App\Http\Requests\Api\V1\Counsellor;

use App\Enums\DownloadCSV;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateCounsellorRequest extends BaseCounsellorRequest
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

            'branchId' => ['required', 'exists:branches,id'],
            'name' => ['required', 'string'],
            'phone' => ['nullable', 'string'],
            'mobile' => ['required', 'string'],
            'whatsapp' => ['nullable', 'string'],
            'canDownloadCsv' => ['nullable', Rule::enum(DownloadCSV::class)],
            'isProcessingOfficer' => ['nullable', 'boolean'],
            'email' => ['sometimes', 'email', Rule::unique('users', 'email')->ignore($this->userId)],
            'password' => ['sometimes', 'string'],
            'passwordConfirmation' => ['sometimes', 'same:password'],
            'userId' => ['required', 'integer', 'exists:users,id'],

        ];
    }

}
