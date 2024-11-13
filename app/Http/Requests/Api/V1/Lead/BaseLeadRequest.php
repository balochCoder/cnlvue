<?php

namespace App\Http\Requests\Api\V1\Lead;

use Illuminate\Foundation\Http\FormRequest;

class BaseLeadRequest extends FormRequest
{
    public function mappedAttributes(array $otherAttributes = []): array
    {
        $attributeMap = array_merge([
            'counsellorId' => 'counsellor_id',
            'leadSourceId' => 'lead_source_id',
            'studentFirstName' => 'student_first_name',
            'studentLastName' => 'student_last_name',
            'intakeOfInterestMonth' => 'intake_of_interest_month',
            'intakeOfInterestYear' => 'intake_of_interest_year',
            'studentEmail' => 'student_email',
            'dateOfBirth' => 'date_of_birth',
            'isCountryPreferred' => 'is_country_preferred',
            'interestedCountryId' => 'interested_country_id',
            'interestedInstitutionId' => 'interested_institution_id',
            'institutionName' => 'institution_name',
            'studentPhone' => 'student_phone',
            'studentEmergencyPhone' => 'student_emergency_phone',
            'studentMobile' => 'student_mobile',
            'studentSkype' => 'student_skype',
            'estimatedBudget' => 'estimated_budget',
            'courseLevelOfInterest' => 'course_level_of_interest',
            'courseCategory' => 'course_category',
            'additionalInfo' => 'additional_info',
            'leadType' => 'lead_type',
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

        if ($this->courseCategory)
        {
            $data['course_category'] = json_encode($this->courseCategory);
        }
        if ($this->leadType)
        {
            $data['status'] = $this->leadType;
        }

        $data['added_by'] = auth()->id();
        return $data;

    }

    public function updateData(): array
    {
        $data = $this->mappedAttributes();
        if ($this->courseCategory)
        {
            $data['course_category'] = json_encode($this->courseCategory);
        }

        if ($this->leadType)
        {
            $data['status'] = $this->leadType;
        }
        return $data;
    }

}
