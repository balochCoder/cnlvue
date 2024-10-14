<?php

namespace App\Http\Requests\Api\V1\ProcessingOffice;

use App\Actions\Fortify\CreateNewUser;
use App\Enums\DownloadCSV;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProcessingOfficeRequest extends BaseProcessingOfficeRequest
{


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
            'contactPersonEmail' => ['required', 'email', Rule::unique('users', 'email')],
            'contactPersonPassword' => ['required', 'string'],
            'contactPersonPasswordConfirmation' => ['required', 'same:contactPersonPassword'],
        ];
    }

}
