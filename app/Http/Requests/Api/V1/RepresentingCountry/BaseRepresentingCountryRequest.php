<?php

namespace App\Http\Requests\Api\V1\RepresentingCountry;

use Illuminate\Foundation\Http\FormRequest;

class BaseRepresentingCountryRequest extends FormRequest
{
    public function mappedAttributes(array $otherAttributes = []): array
    {
        $attributeMap = array_merge([
            'countryId' => 'country_id',
            'monthlyLivingCost' => 'monthly_living_cost',

            'visaRequirements' => 'visa_requirements',
            'countryBenefits' => 'country_benefits',
            'partTimeWorkDetails' => 'part_time_work_details',
            'applicationProcess' => 'applicationProcess',
        ], $otherAttributes);
        $attributesToUpdate = [];
        foreach ($attributeMap as $key => $attribute) {
            if ($this->has($key)){
                $attributesToUpdate[$attribute] = $this->input($key);
            }
        }
        return $attributesToUpdate;
    }
}
