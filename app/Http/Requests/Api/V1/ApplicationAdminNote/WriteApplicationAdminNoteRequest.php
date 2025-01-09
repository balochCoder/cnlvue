<?php

namespace App\Http\Requests\Api\V1\ApplicationAdminNote;


class WriteApplicationAdminNoteRequest extends BaseApplicationAdminNoteRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'counsellorId' => ['required', 'integer', 'exists:counsellors,id'],
            'message' => ['required', 'string'],
            'applicationId' => ['required', 'integer', 'exists:applications,id'],
        ];
    }
}
