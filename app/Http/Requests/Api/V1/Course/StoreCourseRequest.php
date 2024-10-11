<?php

namespace App\Http\Requests\Api\V1\Course;

use App\Enums\ApplicantDesired;
use App\Enums\CourseLevel;
use Illuminate\Validation\Rule;

class StoreCourseRequest extends BaseCourseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'representingInstitutionId' => ['required', Rule::exists('representing_institutions', 'id')],
            'title' => ['required', Rule::unique('courses', 'title')],
            'level' => ['required', Rule::enum(CourseLevel::class)],
            'duration' => ['required', 'array', 'required_array_keys:year,month,weeks'],
            'startDate' => ['nullable', 'date'],
            'endDate' => ['nullable', 'date'],
            'campus' => ['required', 'string'],
            'awardingBody' => ['nullable', 'string'],
            'fee' => ['required', 'numeric'],
            'applicationFee' => ['nullable', 'numeric'],
            'currencyId' => ['required', 'integer', Rule::exists('currencies', 'id')],
            'monthlyLivingCost' => ['numeric', 'nullable'],
            'partTimeWorkDetails' => ['nullable', 'string'],
            'courseBenefits' => ['nullable', 'string'],
            'generalEligibility' => ['nullable', 'string'],
            'qualityOfApplicant' => ['nullable', Rule::enum(ApplicantDesired::class)],
            'isLanguage' => ['nullable', 'boolean'],
            'languageRequirements' => ['required_if:isLanguage,true'],
            'additionalInformation' => ['nullable', 'string'],
            'courseCategory' => ['nullable', 'array'],
            'document1Title' => ['nullable', 'string'],
            'document1' => ['nullable', 'file'],
            'document2Title' => ['nullable', 'string'],
            'document2' => ['nullable', 'file'],
            'document3Title' => ['nullable', 'string'],
            'document3' => ['nullable', 'file'],
            'document4Title' => ['nullable', 'string'],
            'document4' => ['nullable', 'file'],
            'document5Title' => ['nullable', 'string'],
            'document5' => ['nullable', 'file'],
            'modules' => ['nullable', 'array'],
            'intake' => ['required', 'array'],
        ];
    }
    public function messages(): array
    {
        return [
            'currencyId.required' => 'Currency is required.',
            'languageRequirements.required_if' => 'Language requirements field is required if Language mandatory',
        ];
    }


}
