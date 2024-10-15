<?php

namespace App\Http\Requests\Api\V1\Remark;


class WriteRemarkRequest extends BaseRemarkRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'counsellorId' => ['required', 'integer', 'exists:counsellors,id'],
            'remarks' => ['required', 'string'],
            'date' => ['required', 'date'],
        ];
    }
}
