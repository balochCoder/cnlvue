<?php

namespace App\Http\Requests\Api\V1\Counsellor;

use App\Actions\Fortify\CreateNewUser;
use App\Enums\DownloadCSV;
use App\Http\Requests\Api\V1\Counsellor\BaseCounsellorRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCounsellorRequest extends BaseCounsellorRequest
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
            'phone' => ['nullable', 'string'],
            'mobile' => ['required', 'string'],
            'whatsapp' => ['nullable', 'string'],
            'canDownloadCsv' => ['nullable', Rule::enum(DownloadCSV::class)],
            'isProcessingOfficer' => ['nullable', 'boolean'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'string'],
            'passwordConfirmation' => ['required', 'same:password'],
        ];
    }

}
