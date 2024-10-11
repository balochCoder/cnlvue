<?php

namespace App\Http\Requests\Api\V1\RepresentingInstitution;

use App\Models\RepresentingInstitution;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class BaseRepresentingInstitutionRequest extends FormRequest
{
    public function mappedAttributes(array $otherAttributes = []): array
    {
        $attributeMap = array_merge([
            'representingCountryId' => 'representing_country_id',
            'name' => 'name',
            'type' => 'type',
            'campus' => 'campus',
            'website' => 'website',
            'monthlyLivingCost' => 'monthly_living_cost',
            'fundsRequired' => 'funds_required',
            'applicationFee' => 'application_fee',
            'currencyId' => 'currency_id',
            'contractTerm' => 'contract_term',
            'qualityOfApplicant' => 'quality_of_applicant',
            'contractCopy' => 'contract_copy',
            'contractExpiry' => 'contract_expiry',
            'isLanguage' => 'is_language',
            'languageRequirements' => 'language_requirements',
            'institutionalBenefits' => 'institutional_benefits',
            'partTimeWorkDetails' => 'part_time_work_details',
            'scholarshipsPolicy' => 'scholarships_policy',
            'institutionStatusNotes' => 'institution_status_notes',
            'logo' => 'logo',
            'prospectus' => 'prospectus',
            'document1Title' => 'document_1_title',
            'document1' => 'document_1',
            'document2Title' => 'document_2_title',
            'document2' => 'document_2',
            'contactPersonName' => 'contact_person_name',
            'contactPersonEmail' => 'contact_person_email',
            'contactPersonPhone' => 'contact_person_phone',
            'contactPersonDesignation' => 'contact_person_designation',
        ], $otherAttributes);
        $attributesToUpdate = [];
        foreach ($attributeMap as $key => $attribute) {
            if ($this->has($key)) {
                $attributesToUpdate[$attribute] = $this->input($key);
            }
        }
        return $attributesToUpdate;
    }

    public function getData(): array
    {

        $data = $this->mappedAttributes();
        if ($this->hasFile('contractCopy')) {
            $directory = RepresentingInstitution::makeDirectory('contract_copy');
            $data['contract_copy'] = Storage::url('/') .$this->contractCopy->store($directory);
        }
        if ($this->hasFile('logo')) {
            $directory = RepresentingInstitution::makeDirectory('logo');
            $data['logo'] = Storage::url('/') .$this->logo->store($directory);
        }
        if ($this->hasFile('prospectus')) {
            $directory = RepresentingInstitution::makeDirectory('prospectus');
            $data['prospectus'] = $this->prospectus->store($directory);
        }
        if ($this->hasFile('document1')) {
            $directory = RepresentingInstitution::makeDirectory('document_1');
            $data['document_1'] = Storage::url('/') .$this->document1->store($directory);
        }
        if ($this->hasFile('document2')) {
            $directory = RepresentingInstitution::makeDirectory('document_2');
            $data['document_2'] = Storage::url('/') .$this->document2->store($directory);
        }

        return $data;
    }
}
