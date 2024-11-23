<?php

namespace App\Http\Requests\Api\V1\Quotation;




class StoreQuotationRequest extends BaseQuotationRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'studentGender' => ['required', 'string', 'in:Male,Female'],
            'studentTitle' => ['required', 'string', 'in:Mr,Mrs,Ms,Miss'],
            'studentFirstName' => ['required', 'string', 'min:2', 'max:255'],
            'studentLastName' => ['required', 'string', 'min:2', 'max:255'],
            'dateOfBirth' => ['required', 'date'],
            'studentMaritalStatus' => ['required', 'string', 'in:Married,Single'],
            'studentNationality' => ['required', 'string'],
            'isValidPassport' => ['required', 'boolean'],
            'studentPassport' => ['required_if:isValidPassport,true', 'string'],
            'studentPhone' => ['nullable', 'string'],
            'studentEmail' => ['nullable', 'email', 'string'],
            'studentMobile' => ['nullable', 'string'],
            'studentImage' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
//            Permanent Address
            'permanentAddress' => ['nullable', 'array', 'required_array_keys:address,city,state,country', function ($attribute, $value, $fail) {
                $allowedKeys = ['address', 'city', 'state', 'country'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
//            Correspondance Address
            'correspondenceAddress' => ['nullable', 'array', 'required_array_keys:address,city,state,country', function ($attribute, $value, $fail) {
                $allowedKeys = ['address', 'city', 'state', 'country'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            //Education History
            'educationHistory' => ['nullable', 'array'],
            'educationHistory.*.institution' => ['required_with:educationHistory', 'string'],
            'educationHistory.*.qualification' => ['required_with:educationHistory', 'string'],
            'educationHistory.*.year' => ['required_with:educationHistory', 'integer'],
            'educationHistory.*.grade' => ['required_with:educationHistory', 'string'],
            'educationHistory.*.file' => ['required_with:educationHistory', 'file'],

            //English Language
            'englishLanguage' => ['nullable', 'array'],
            //English Language IELTS
            'englishLanguage.ielts' => ['array', 'required_array_keys:listening,reading,speaking,writing,score,date,additional,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['listening', 'reading', 'speaking', 'writing', 'score', 'date', 'additional', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'englishLanguage.ielts.listening' => ['required_with:englishLanguage.ielts', 'decimal:0,1'],
            'englishLanguage.ielts.speaking' => ['required_with:englishLanguage.ielts', 'decimal:0,1'],
            'englishLanguage.ielts.reading' => ['required_with:englishLanguage.ielts', 'decimal:0,1'],
            'englishLanguage.ielts.writing' => ['required_with:englishLanguage.ielts', 'decimal:0,1'],
            'englishLanguage.ielts.score' => ['required_with:englishLanguage.ielts', 'decimal:0,1'],
            'englishLanguage.ielts.date' => ['required_with:englishLanguage.ielts', 'date'],
            'englishLanguage.ielts.additional' => ['required_with:englishLanguage.ielts', 'string'], 'englishLanguage.ielts.file' => ['required_with:englishLanguage.ielts', 'file'],
            //English Language TOEFL
            'englishLanguage.toefl' => ['array', 'required_array_keys:listening,reading,speaking,writing,score,date,additional,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['listening', 'reading', 'speaking', 'writing', 'score', 'date', 'additional', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'englishLanguage.toefl.listening' => ['required_with:englishLanguage.toefl', 'decimal:0,1'],
            'englishLanguage.toefl.speaking' => ['required_with:englishLanguage.toefl', 'decimal:0,1'],
            'englishLanguage.toefl.reading' => ['required_with:englishLanguage.toefl', 'decimal:0,1'],
            'englishLanguage.toefl.writing' => ['required_with:englishLanguage.toefl', 'decimal:0,1'],
            'englishLanguage.toefl.score' => ['required_with:englishLanguage.toefl', 'decimal:0,1'],
            'englishLanguage.toefl.date' => ['required_with:englishLanguage.toefl', 'date'],
            'englishLanguage.toefl.additional' => ['required_with:englishLanguage.toefl', 'string'],
            'englishLanguage.toefl.file' => ['required_with:englishLanguage.toefl', 'file'],
            //English Language PTE
            'englishLanguage.pte' => ['array', 'required_array_keys:listening,reading,speaking,writing,score,date,additional,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['listening', 'reading', 'speaking', 'writing', 'score', 'date', 'additional', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'englishLanguage.pte.listening' => ['required_with:englishLanguage.pte', 'decimal:0,1'],
            'englishLanguage.pte.speaking' => ['required_with:englishLanguage.pte', 'decimal:0,1'],
            'englishLanguage.pte.reading' => ['required_with:englishLanguage.pte', 'decimal:0,1'],
            'englishLanguage.pte.writing' => ['required_with:englishLanguage.pte', 'decimal:0,1'],
            'englishLanguage.pte.score' => ['required_with:englishLanguage.pte', 'decimal:0,1'],
            'englishLanguage.pte.date' => ['required_with:englishLanguage.pte', 'date'],
            'englishLanguage.pte.additional' => ['required_with:englishLanguage.pte', 'string'],
            'englishLanguage.pte.file' => ['required_with:englishLanguage.pte', 'file'],
//            English Language GMAT
            'englishLanguage.gmat' => ['array', 'required_array_keys:listening,reading,speaking,writing,score,date,additional,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['listening', 'reading', 'speaking', 'writing', 'score', 'date', 'additional', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'englishLanguage.gmat.listening' => ['required_with:englishLanguage.gmat', 'decimal:0,1'],
            'englishLanguage.gmat.speaking' => ['required_with:englishLanguage.gmat', 'decimal:0,1'],
            'englishLanguage.gmat.reading' => ['required_with:englishLanguage.gmat', 'decimal:0,1'],
            'englishLanguage.gmat.writing' => ['required_with:englishLanguage.gmat', 'decimal:0,1'],
            'englishLanguage.gmat.score' => ['required_with:englishLanguage.gmat', 'decimal:0,1'],
            'englishLanguage.gmat.date' => ['required_with:englishLanguage.gmat', 'date'],
            'englishLanguage.gmat.additional' => ['required_with:englishLanguage.gmat', 'string'],
            'englishLanguage.gmat.file' => ['required_with:englishLanguage.gmat', 'file'],
            //English Language OTHERS
            'englishLanguage.others' => ['nullable', 'array'],
            'englishLanguage.others.info' => ['nullable', 'string'],
            'englishLanguage.others.file' => ['required_with:englishLanguage.others.info', 'file'],

            //Work Experience
            'workExperience' => ['nullable', 'array'],
            'workExperience.*.employer' => ['required_with:workExperience', 'string'],
            'workExperience.*.position' => ['required_with:workExperience', 'string'],
            'workExperience.*.period' => ['required_with:workExperience', 'string'],
            'workExperience.*.responsibilities' => ['required_with:workExperience', 'string'],
            'workExperience.*.file' => ['required_with:workExperience', 'file'],

            //References
            'references' => ['nullable', 'array'],
            'references.*.name' => ['required_with:references', 'string'],
            'references.*.designation' => ['required_with:references', 'string'],
            'references.*.institution' => ['required_with:references', 'string'],
            'references.*.email' => ['required_with:references', 'string'],
            'references.*.phone' => ['required_with:references', 'string'],
            'references.*.address' => ['required_with:references', 'string'],
            'references.*.city' => ['required_with:references', 'string'],
            'references.*.state' => ['nullable', 'string'],
            'references.*.country' => ['required_with:references', 'string'],
            'references.*.zip' => ['nullable', 'string'],

            //Statement of Purpose
            'statementOfPurpose' => ['nullable', 'array','required_array_keys:sop,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['sop', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'statementOfPurpose.sop' => ['nullable', 'string'],
            'statementOfPurpose.file' => ['nullable', 'file'],

            //Is Accomodation Required
            'isAccommodationRequired' => ['required', 'boolean'],

            //Is Medica lRequired
            'isMedicalRequired' => ['required', 'boolean'],
            'medicalHistory' => ['required_if:isMedicalRequired,true', 'string'],

            //Additional Information
            'additionalInformation' => ['nullable', 'string'],

            //Additional Documents
            'additionalDocuments' => ['nullable', 'array'],
            'additionalDocuments.*.title' => ['nullable', 'string'],
            'additionalDocuments.*.file' => ['required_with:additionalDocuments.*.title', 'file'],
            //Lead Id
            'leadId' => ['required','exists:leads,id'],

            //CountryId, CourseId, InstitutionId
            'choices' => ['nullable','array'],
            'choices.*.countryId' => ['nullable', 'exists:representing_countries,id'],
            'choices.*.institutionId' => ['required_with:choices.*.countryId', 'exists:representing_institutions,id'],
            'choices.*.courseId' => ['required_with:choices.*.countryId', 'exists:courses,id'],
        ];
    }
}
