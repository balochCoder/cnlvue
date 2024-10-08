<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\ApplicantDesired;
use App\Enums\InstituteType;
use App\Models\RepresentingInstitution;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RepresentingInstitutionRequest extends FormRequest
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
            'representing_country_id' => ['required', Rule::exists('representing_countries', 'id')->where('is_active', true)],
            'name' => ['required', Rule::unique('representing_institutions', 'name')],
            'type' => ['required', Rule::enum(InstituteType::class)],
            'campus' => ['nullable', 'string'],
            'website' => ['required', 'url'],
            'monthly_living_cost' => ['numeric', 'nullable'],
            'funds_required' => ['nullable', 'numeric'],
            'application_fee' => ['nullable', 'numeric'],
            'currency_id' => ['nullable', 'integer', Rule::exists('currencies', 'id')],
            'contract_term' => ['nullable', 'numeric'],
            'quality_of_applicant' => ['nullable', Rule::enum(ApplicantDesired::class)],
            'contract_copy' => ['nullable', 'file'],
            'contract_expiry' => ['nullable', 'date'],
            'is_language' => ['nullable', 'boolean'],
            'language_requirements' => ['required_if:is_language,true'],
            'institutional_benefits' => ['nullable', 'string'],
            'part_time_work_details' => ['nullable', 'string'],
            'scholarships_policy' => ['nullable', 'string'],
            'institution_status_notes' => ['nullable', 'string'],
            'logo' => ['nullable', 'image'],
            'prospectus' => ['nullable', 'file'],
            'document_1_title' => ['nullable', 'string'],
            'document_1' => ['nullable', 'file'],
            'document_2_title' => ['nullable', 'string'],
            'document_2' => ['nullable', 'file'],
            'contact_person_name' => ['required', 'string'],
            'contact_person_email' => ['required', 'string', 'email'],
            'contact_person_phone' => ['required'],
            'contact_person_designation' => ['required']
        ];
    }

    public function getData()
    {

        $data = $this->validated();
        if ($this->hasFile('contract_copy')) {
            $directory = RepresentingInstitution::makeDirectory('contract_copy');
            $data['contract_copy'] = Storage::url('/') .$this->contract_copy->store($directory);
        }
        if ($this->hasFile('logo')) {
            $directory = RepresentingInstitution::makeDirectory('logo');
            $data['logo'] = Storage::url('/') .$this->logo->store($directory);
        }
        if ($this->hasFile('prospectus')) {
            $directory = RepresentingInstitution::makeDirectory('prospectus');
            $data['prospectus'] = $this->prospectus->store($directory);
        }
        if ($this->hasFile('document_1')) {
            $directory = RepresentingInstitution::makeDirectory('document_1');
            $data['document_1'] = Storage::url('/') .$this->document_1->store($directory);
        }
        if ($this->hasFile('document_2')) {
            $directory = RepresentingInstitution::makeDirectory('document_2');
            $data['document_2'] = Storage::url('/') .$this->document_2->store($directory);
        }

        return $data;
    }
}
