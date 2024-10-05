<?php

namespace App\Http\Requests\Api\V1;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Foundation\Http\FormRequest;

class StoreFrontOfficeRequest extends FormRequest
{
    protected mixed $createNewUser;

    public function __construct()
    {
        parent::__construct();
        $this->createNewUser = app(CreateNewUser::class);
    }

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'branch_id' => ['required', 'exists:branches,id'],
            'name' => ['required', 'string'],
            'phone' => ['nullable'],
            'mobile' => ['nullable'],
            'edit_leads' => ['nullable', 'boolean'],
            'user_email' => ['required', 'email'],
            'password' => ['required', 'string', 'confirmed'],
        ];
    }

    public function createUser()
    {
        return $this->createNewUser->create([
            'name' => $this->input('name'),
            'email' => $this->input('user_email'),
            'password' => $this->input('password'),
            'password_confirmation' => $this->input('password_confirmation'),
        ]);
    }

    public function getData()
    {
        $data = $this->validated();
        $user = $this->createUser();

        $user->assignRole('front_office');

        //TODO: Send an Email to user with login details
        $data['user_id'] = $user->id;
        return $data;
    }
}
