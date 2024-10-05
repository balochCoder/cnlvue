<?php

namespace App\Http\Requests\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdateFrontOfficeRequest extends FormRequest
{

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
            'user_email' => ['sometimes', 'email'],
            'password' => ['sometimes', 'confirmed'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    public function getData()
    {
        $data = $this->validated();
        $user = User::query()->findOrFail($data['user_id']);

        $user->update([
            'email' => $data['user_email'],
            'name' => $data['name'],
        ]);

        if ($data['user_email'] && $data['password']) {
            $user->update([
                'email'=>$data['user_email'],
                'password'=>Hash::make($data['password'])
            ]);
        }

        return $data;
    }
}
