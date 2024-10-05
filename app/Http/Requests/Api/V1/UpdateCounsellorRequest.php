<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\DownloadCSV;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateCounsellorRequest extends FormRequest
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
            'branch_id' => ['required', 'exists:branches,id'],
            'name' => ['required', 'string'],
            'phone' => ['nullable'],
            'is_active' => ['nullable', 'boolean'],
            'mobile' => ['required'],
            'whatsapp' => ['nullable'],
            'download_csv' => ['nullable', Rule::enum(DownloadCSV::class)],
            'is_processing_officer' => ['nullable', 'boolean'],
            'user_email' => ['sometimes', 'email'],
            'password' => ['sometimes', 'confirmed'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    public function getData()
    {
        $data = $this->validated();
        $user = User::query()->find($data['user_id']);
        if (!$data['is_processing_officer']) {
            $user->removeRole('processing_officer');
        }
        if ($data['is_processing_officer']) {
            $user->assignRole('processing_officer');
        }

        $user->update([
            'email' => $data['user_email'],
            'name' => $data['name']
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
