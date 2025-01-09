<?php

namespace App\Http\Requests\Api\V1\ApplicationAdminNote;

use App\Models\Counsellor;
use Illuminate\Foundation\Http\FormRequest;

class BaseApplicationAdminNoteRequest extends FormRequest
{
    public function mappedAttributes(array $otherAttributes = []): array
    {
        $attributeMap = array_merge([
            'counsellorId' => 'counsellor_id',
            'message' => 'message',
            'applicationId' => 'application_id',
        ], $otherAttributes);
        $attributesToUpdate = [];
        foreach ($attributeMap as $key => $attribute) {
            if ($this->has($key)) {
                $attributesToUpdate[$attribute] = $this->input($key);
            }
        }
        return $attributesToUpdate;
    }

    public function storeData(): array
    {
        $data = $this->mappedAttributes();
        $counsellor = Counsellor::where('user_id', auth()->user()->id)->first();
        $data['counsellor_id'] = $counsellor->id;
        return $data;
    }

}
