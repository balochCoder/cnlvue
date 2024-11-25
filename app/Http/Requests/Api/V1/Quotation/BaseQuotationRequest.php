<?php

namespace App\Http\Requests\Api\V1\Quotation;

use App\Models\Lead;
use App\Models\Quotation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class BaseQuotationRequest extends FormRequest
{
    public function mappedAttributes(array $otherAttributes = []): array
    {
        $attributeMap = array_merge([
            'studentNationality' => 'student_nationality',
            'studentPassport' => 'student_passport',
            'studentImage' => 'student_image',
            'medicalHistory' => 'medical_history',
            'additionalInformation' => 'additional_information',
            'permanentAddress' => 'permanent_address',
            'correspondenceAddress' => 'correspondence_address',
            'educationHistory' => 'education_history',
            'englishLanguage' => 'english_language',
            'workExperience' => 'work_experience',
            'references' => 'references',
            'statementOfPurpose' => 'statement_of_purpose',
            'additionalDocuments' => 'additional_documents',
            'studentGender' => 'student_gender',
            'studentTitle' => 'student_title',
            'studentMaritalStatus' => 'student_marital_status',
            'isValidPassport' => 'is_valid_passport',
            'isAccommodationRequired' => 'is_accommodation_required',
            'isMedicalRequired' => 'is_medical_required',
            'leadId' => 'lead_id',
            'isIELTS' => 'is_ielts',
            'isPTE'=> 'is_pte',
            'isTOEFL'=> 'is_toefl',
            'isGMAT'=> 'is_gmat',
            'choices' => 'choices',


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

        if ($this->hasFile('studentImage')) {
            $directory = Quotation::makeDirectory('student_image');
            $data['student_image'] = Storage::url('/') . $this->studentImage->store($directory);
        }
        if ($this->educationHistory) {
            foreach ($this->educationHistory as $index => $educationHistory) {
                if ($this->hasFile("educationHistory.$index.file")) {
                    $directory = Quotation::makeDirectory('education_history');
                    $data['education_history'][$index]["file"] = Storage::url('/') . $educationHistory['file']->store($directory);
                }
            }
            $data['education_history'] = json_encode($data['education_history']);
        }
        if ($this->englishLanguage) {
            if ($this->hasFile("englishLanguage.ielts.file")) {
                $directory = Quotation::makeDirectory('english_language/ielts');
                $data['english_language']['ielts']['file'] = Storage::url('/') . $this->englishLanguage['ielts']['file']->store($directory);
            }
            if ($this->hasFile("englishLanguage.toefl.file")) {
                $directory = Quotation::makeDirectory('english_language/toefl');
                $data['english_language']['toefl']['file'] = Storage::url('/') . $this->englishLanguage['toefl']['file']->store($directory);
            }
            if ($this->hasFile("englishLanguage.pte.file")) {
                $directory = Quotation::makeDirectory('english_language/pte');
                $data['english_language']['pte']['file'] = Storage::url('/') . $this->englishLanguage['pte']['file']->store($directory);
            }
            if ($this->hasFile("englishLanguage.gmat.file")) {
                $directory = Quotation::makeDirectory('english_language/gmat');
                $data['english_language']['gmat']['file'] = Storage::url('/') . $this->englishLanguage['gmat']['file']->store($directory);
            }
            if ($this->hasFile("englishLanguage.others.file")) {
                $directory = Quotation::makeDirectory('english_language/others');
                $data['english_language']['others']['file'] = Storage::url('/') . $this->englishLanguage['others']['file']->store($directory);
            }

            $data['english_language'] = json_encode($data['english_language']);
        }
        if ($this->workExperience) {
            foreach ($this->workExperience as $index => $workExperience) {
                if ($this->hasFile("workExperience.$index.file")) {
                    $directory = Quotation::makeDirectory('work_experience');
                    $data['work_experience'][$index]['file'] = Storage::url('/') . $workExperience['file']->store($directory);
                }
            }
            $data['work_experience'] = json_encode($data['work_experience']);
        }
        if ($this->statementOfPurpose) {

            if ($this->hasFile("statementOfPurpose.file")) {
                $directory = Quotation::makeDirectory('statement_of_purpose');
                $data['statement_of_purpose']['file'] = Storage::url('/') . $this->statementOfPurpose['file']->store($directory);
            }

            $data['statement_of_purpose'] = json_encode($data['statement_of_purpose']);
        }
        if ($this->additionalDocuments) {
            foreach ($this->additionalDocuments as $index => $additionalDocument) {
                if ($this->hasFile("additionalDocuments.$index.file")) {
                    $directory = Quotation::makeDirectory('additional_document');
                    $data['additional_documents'][$index]['file'] = Storage::url('/') . $additionalDocument['file']->store($directory);
                }
            }
            $data['additional_documents'] = json_encode($data['additional_documents']);
        }
        if ($this->references) {

            $data['references'] = json_encode($this->references);
        }
        if ($this->permanentAddress) {
            $data['permanent_address'] = json_encode($this->permanentAddress);
        }
        if ($this->correspondenceAddress) {
            $data['correspondence_address'] = json_encode($this->correspondenceAddress);
        }

        $lead = Lead::findOrFail($this->leadId);
        $lead?->update([
            'student_first_name' => $this->studentFirstName,
            'student_last_name' => $this->studentLastName,
            'student_email' => $this->studentEmail,
            'student_phone' => $this->studentPhone,
            'student_mobile' => $this->studentMobile,
            'student_skype' => $this->studentSkype,
            'date_of_birth' => $this->dateOfBirth
        ]);
        $data['added_by'] = auth()->id();
        return $data;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'isValidPassport' => filter_var($this->input('isValidPassport'), FILTER_VALIDATE_BOOLEAN),
            'isAccommodationRequired' => filter_var($this->input('isAccommodationRequired'), FILTER_VALIDATE_BOOLEAN),
            'isMedicalRequired' => filter_var($this->input('isMedicalRequired'), FILTER_VALIDATE_BOOLEAN),
            'isIELTS' => filter_var($this->input('isIELTS'), FILTER_VALIDATE_BOOLEAN),
            'isTOEFL' => filter_var($this->input('isTOEFL'), FILTER_VALIDATE_BOOLEAN),
            'isPTE' => filter_var($this->input('isPTE'), FILTER_VALIDATE_BOOLEAN),
            'isGMAT' => filter_var($this->input('isGMAT'), FILTER_VALIDATE_BOOLEAN),
        ]);
    }

}
