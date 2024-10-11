<?php

namespace App\Actions\Fortify;

use App\Enums\DownloadCSV;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'mobile' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:255'],
            'skype' => ['nullable', 'string', 'max:255'],
            'download_csv' => ['nullable', Rule::enum(DownloadCSV::class)],
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'mobile' => $input['mobile'],
            'phone' => $input['phone'],
            'designation' => $input['designation'],
            'whatsapp' => $input['whatsapp'],
            'skype' => $input['skype'],
            'download_csv' => $input['download_csv'],
        ]);
    }
}
