<?php

namespace App\Http\Requests\Api\V1\Branch;

use App\Enums\DownloadCSV;
use Illuminate\Validation\Rule;

class UpdateBranchRequest extends BaseBranchRequest
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
            'branchEmail' => ['nullable', 'email'],
            'branchPhone' => ['nullable', 'string'],
            'branchWebsite' => ['nullable', 'url'],
            'canDownloadCsv' => ['nullable', Rule::enum(DownloadCSV::class)],
            'contactPersonName' => ['required', 'string'],
            'contactPersonDesignation' => ['required', 'string'],
            'contactPersonPhone' => ['nullable', 'string'],
            'contactPersonMobile' => ['required', 'string'],
            'contactPersonWhatsapp' => ['nullable', 'string'],
            'contactPersonSkype' => ['nullable', 'string'],
            'contactPersonEmail' => ['sometimes', 'email', Rule::unique('users', 'email')->ignore($this->userId)],
            'contactPersonPassword' => ['sometimes','nullable'],
            'contactPersonPasswordConfirmation'=>['sometimes','same:contactPersonPassword'],
            'userId' => ['required', 'integer', 'exists:users,id'],
        ];
    }

}
