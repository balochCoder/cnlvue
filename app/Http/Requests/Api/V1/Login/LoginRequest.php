<?php

namespace App\Http\Requests\Api\V1\Login;

use Illuminate\Foundation\Http\FormRequest;
use Laravel\Fortify\Fortify;

class LoginRequest extends \Laravel\Fortify\Http\Requests\LoginRequest
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
            Fortify::username() => 'required|string',
            'password' => 'required|string',
            'loginType' => 'required|string'
        ];
    }
}
