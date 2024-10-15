<?php

namespace App\Http\Requests\Api\V1\LeadSource;

class WriteLeadSourceRequest extends BaseLeadSourceRequest
{


    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sourceName' => ['required', 'string'],
        ];
    }

}
