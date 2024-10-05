<?php

namespace App\Http\Requests\Api\V1;

use App\Actions\Fortify\CreateNewUser;
use App\Enums\DownloadCSV;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProcessingOfficeRequest extends FormRequest
{
    protected mixed $createNewUser;

    public function __construct()
    {
        parent::__construct();
        $this->createNewUser = app(CreateNewUser::class);
    }

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
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'time_zone_id' => ['nullable', 'integer', 'exists:time_zones,id'],
            'processing_office_phone' => ['nullable', 'string'],
            'download_csv' => ['nullable', Rule::enum(DownloadCSV::class)],
            'contact_person_name' => ['required', 'string'],
            'contact_person_designation' => ['required', 'string'],
            'contact_person_phone' => ['nullable', 'string'],
            'contact_person_mobile' => ['required', 'string'],
            'contact_person_skype' => ['nullable', 'string'],
            'user_email' => ['required', 'email'],
            'password' => ['required', 'string', 'confirmed'],
        ];
    }

    public function createUser()
    {
        return $this->createNewUser->create([
            'name' => $this->input('contact_person_name'),
            'email' => $this->input('user_email'),
            'password' => $this->input('password'),
            'password_confirmation' => $this->input('password_confirmation'),
        ]);
    }

    public function getData()
    {
        $data = $this->validated();
        $user = $this->createUser();
        $user->assignRole('processing_officer');
        //TODO: Send an Email to user with login details
        $data['user_id'] = $user->id;
        return $data;
    }


}
