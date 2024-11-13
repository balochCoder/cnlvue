<?php

namespace App\Http\Requests\Api\V1\Followup;

use Illuminate\Foundation\Http\FormRequest;

class BaseFollowupRequest extends FormRequest
{
    public function mappedAttributes(array $otherAttributes = []): array
    {
        $attributeMap = array_merge([
            'leadType' => 'lead_type',
            'remarks' => 'remarks',
            'followUpDate' => 'follow_up_date',
            'followUpMode' => 'follow_up_mode',
            'time' => 'time'
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
        $data['time'] = json_encode($this->time);
        $data['added_by'] = auth()->id();
        return $data;

    }
}
