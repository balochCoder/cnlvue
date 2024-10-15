<?php

namespace App\Http\Requests\Api\V1\Target;


class WriteTargetRequest extends BaseTargetRequest
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
            'counsellorId' => ['required', 'integer', 'exists:counsellors,id'],
            'description' => ['required', 'string'],
            'number' => ['required', 'integer', 'min:1'],
            'year' => ['required','integer'],
        ];
    }
}
