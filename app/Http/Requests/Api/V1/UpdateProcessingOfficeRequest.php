<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\DownloadCSV;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateProcessingOfficeRequest extends FormRequest
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
            'is_active' => ['nullable', 'boolean'],
            'state' => ['nullable', 'string'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'time_zone_id' => ['nullable', 'integer', 'exists:time_zones,id'],
            'processing_office_phone' => ['nullable', 'string'],
            'download_csv' => ['nullable', Rule::enum(DownloadCSV::class)],
            'contact_person_name' => ['required', 'string'],
            'contact_person_designation' => ['required', 'string'],
            'contact_person_phone' => ['nullable', 'string'],
            'contact_person_mobile' => ['required', 'string'],
            'contact_person_skype' => ['nullable', 'string'],
            'user_email' => ['sometimes', 'email'],
            'password' => ['sometimes', 'confirmed'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    public function getData()
    {
        $data = $this->validated();
        $user = User::query()->find($data['user_id']);
        $user->update([
            'name' => $data['contact_person_name'],
            'email' => $data['user_email']
        ]);
        if ($data['user_email'] && $data['password']) {
            $user->update([
                'email' => $data['user_email'],
                'password' => Hash::make($data['password']),
            ]);
        }

        return $data;

    }
}
