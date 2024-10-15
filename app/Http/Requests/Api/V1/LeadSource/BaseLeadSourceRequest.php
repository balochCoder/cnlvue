<?php

namespace App\Http\Requests\Api\V1\LeadSource;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class BaseLeadSourceRequest extends FormRequest
{


    public function mappedAttributes(array $otherAttributes = []): array
    {
        $attributeMap = array_merge([
            'sourceName' => 'source_name',
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

    public function updateData(): array
    {
        return $this->mappedAttributes();

    }
}
