<?php

namespace App\Http\Requests\Api\V1\ProcessingOffice;

use App\Enums\DownloadCSV;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateProcessingOfficeRequest extends BaseProcessingOfficeRequest
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
            'name' => ['required', 'string'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'countryId' => ['required', 'integer', 'exists:countries,id'],
            'timeZoneId' => ['nullable', 'integer', 'exists:time_zones,id'],
            'officePhone' => ['nullable', 'string'],
            'canDownloadCsv' => ['nullable', Rule::enum(DownloadCSV::class)],
            'contactPersonName' => ['required', 'string'],
            'contactPersonDesignation' => ['required', 'string'],
            'contactPersonPhone' => ['nullable', 'string'],
            'contactPersonMobile' => ['required', 'string'],
            'contactPersonSkype' => ['nullable', 'string'],
            'contactPersonEmail' => ['sometimes', 'email', Rule::unique('users', 'email')->ignore($this->userId)],
            'contactPersonPassword' => ['sometimes'],
            'contactPersonPasswordConfirmation' => ['sometimes', 'same:contactPersonPassword'],
            'userId' => ['required', 'integer', 'exists:users,id'],
        ];
    }


}
