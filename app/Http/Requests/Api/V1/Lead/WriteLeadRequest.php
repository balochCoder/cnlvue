<?php

namespace App\Http\Requests\Api\V1\Lead;


use App\Enums\FollowupMode;
use App\Enums\LeadStatus;
use Illuminate\Validation\Rule;

class WriteLeadRequest extends BaseLeadRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'branchId' => ['required', 'exists:branches,id'],
            'counsellorId' => ['required', 'exists:counsellors,id','array'],
            'leadSourceId' => ['required', 'integer', 'exists:lead_sources,id'],
            'studentFirstName' => ['required', 'string'],
            'studentLastName' => ['required', 'string'],
            'intakeOfInterestMonth' => ['nullable', 'string'],
            'intakeOfInterestYear' => ['nullable', 'string'],
            'studentEmail' => ['nullable', 'string', 'email'],
            'dateOfBirth' => ['nullable', 'date'],
            'isCountryPreferred' => ['boolean'],
            'interestedCountryId' => ['required_if:isCountryPreferred,true', 'nullable', 'integer', 'exists:countries,id'],
            'interestedInstitutionId' => ['nullable','integer', 'exists:representing_institutions,id'],
            'institutionName' => ['nullable', 'string'],
            'studentPhone' => ['nullable', 'string'],
            'studentEmergencyPhone' => ['nullable', 'string'],
            'studentMobile' => ['nullable', 'string'],
            'studentSkype' => ['nullable', 'string'],
            'estimatedBudget' => ['nullable', 'string'],
            'courseLevelOfInterest' => ['nullable', 'string'],
            'courseCategory' => ['nullable', 'array'],
            'additionalInfo' => ['nullable', 'string'],
            'leadType' => ['nullable', 'string', Rule::enum(LeadStatus::class)],
            'followUpDate' => ['required_with:leadType', 'nullable','date'],
            'followUpMode' => ['required_with:leadType', 'nullable','string', Rule::enum(FollowupMode::class)],
            'time' => ['required_with:leadType', 'array', "required_array_keys:hour,minute,zone"],
            'remarks' => ['required_with:leadType', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'isCountryPreferred' => filter_var($this->input('isCountryPreferred'), FILTER_VALIDATE_BOOLEAN),
        ]);
    }
}
