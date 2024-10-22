<?php

namespace App\Http\Requests\Api\V1\RepresentingInstitution;

use App\Enums\ApplicantDesired;
use App\Enums\InstituteType;
use Illuminate\Validation\Rule;

class UpdateRepresentingInstituionRequest extends BaseRepresentingInstitutionRequest
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
            'representingCountryId' => ['required', Rule::exists('representing_countries', 'id')->where('is_active', true)],
            'name' => ['required', Rule::unique('representing_institutions', 'name')->ignore($this->representing_institution->id)],
            'type' => ['required', Rule::enum(InstituteType::class)],
            'campus' => ['nullable', 'string'],
            'website' => ['required', 'url'],
            'monthlyLivingCost' => ['numeric', 'nullable'],
            'fundsRequired' => ['nullable', 'numeric'],
            'applicationFee' => ['nullable', 'numeric'],
            'currencyId' => ['nullable', 'integer', Rule::exists('currencies', 'id')],
            'contractTerm' => ['nullable', 'numeric'],
            'qualityOfApplicant' => ['nullable', Rule::enum(ApplicantDesired::class)],
            'contractCopy' => ['sometimes', 'file'],
            'contractExpiry' => ['nullable', 'date'],
            'isLanguage' => ['nullable', 'boolean'],
            'languageRequirements' => ['required_if:isLanguage,true'],
            'institutionalBenefits' => ['nullable', 'string'],
            'partTimeWorkDetails' => ['nullable', 'string'],
            'scholarshipsPolicy' => ['nullable', 'string'],
            'institutionStatusNotes' => ['nullable', 'string'],
            'logo' => ['sometimes', 'image'],
            'prospectus' => ['sometimes', 'file'],
            'document1Title' => ['nullable', 'string'],
            'document1' => ['sometimes', 'file'],
            'document2Title' => ['nullable', 'string'],
            'document2' => ['sometimes', 'file'],
            'contactPersonName' => ['required', 'string'],
            'contactPersonEmail' => ['required', 'string', 'email'],
            'contactPersonPhone' => ['required'],
            'contactPersonDesignation' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'languageRequirements.required_if' => 'Language Requirements is required.',
        ];
    }
}
