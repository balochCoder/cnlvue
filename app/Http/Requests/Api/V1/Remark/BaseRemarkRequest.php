<?php

namespace App\Http\Requests\Api\V1\Remark;

use Illuminate\Foundation\Http\FormRequest;

class BaseRemarkRequest extends FormRequest
{
    public function mappedAttributes(array $otherAttributes = []): array
    {
        $attributeMap = array_merge([
            'counsellorId' => 'counsellor_id',
            'remarks' => 'remarks',
            'addDate' => 'add_date',
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
        $data['added_by'] = auth()->id();
        return $data;
    }

}
