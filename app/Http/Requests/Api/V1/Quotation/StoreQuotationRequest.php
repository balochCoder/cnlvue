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
            'studentPassport' => ['required_if:isValidPassport,true', 'nullable', 'string'],
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
            'educationHistory.*.institution' => ['nullable', 'string'],
            'educationHistory.*.qualification' => ['nullable', 'string'],
            'educationHistory.*.year' => ['nullable', 'integer'],
            'educationHistory.*.grade' => ['nullable', 'string'],
            'educationHistory.*.file' => ['nullable', 'file'],

            'isIELTS' => ['nullable', 'boolean'],
            'isTOEFL' => ['nullable', 'boolean'],
            'isPTE' => ['nullable', 'boolean'],
            'isGMAT' => ['nullable', 'boolean'],

            //English Language
            'englishLanguage' => ['nullable', 'array'],
            //English Language IELTS
            'englishLanguage.ielts' => ['array', 'required_array_keys:listening,reading,speaking,writing,score,date,additional,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['listening', 'reading', 'speaking', 'writing', 'score', 'date', 'additional', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'englishLanguage.ielts.listening' => ['required_if:isIELTS,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.ielts.speaking' => ['required_if:isIELTS,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.ielts.reading' => ['required_if:isIELTS,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.ielts.writing' => ['required_if:isIELTS,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.ielts.score' => ['required_if:isIELTS,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.ielts.date' => ['required_if:isIELTS,true', 'nullable', 'date'],
            'englishLanguage.ielts.additional' => ['required_if:isIELTS,true', 'nullable', 'string'],
            'englishLanguage.ielts.file' => ['required_if:isIELTS,true', 'nullable', 'file'],
            //English Language TOEFL
            'englishLanguage.toefl' => ['array', 'required_array_keys:listening,reading,speaking,writing,score,date,additional,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['listening', 'reading', 'speaking', 'writing', 'score', 'date', 'additional', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'englishLanguage.toefl.listening' => ['required_if:isTOEFL,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.toefl.speaking' => ['required_if:isTOEFL,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.toefl.reading' => ['required_if:isTOEFL,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.toefl.writing' => ['required_if:isTOEFL,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.toefl.score' => ['required_if:isTOEFL,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.toefl.date' => ['required_if:isTOEFL,true', 'nullable', 'date'],
            'englishLanguage.toefl.additional' => ['required_if:isTOEFL,true', 'nullable', 'string'],
            'englishLanguage.toefl.file' => ['required_if:isTOEFL,true', 'nullable', 'file'],
            //English Language PTE
            'englishLanguage.pte' => ['array', 'required_array_keys:listening,reading,speaking,writing,score,date,additional,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['listening', 'reading', 'speaking', 'writing', 'score', 'date', 'additional', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'englishLanguage.pte.listening' => ['required_if:isPTE,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.pte.speaking' => ['required_if:isPTE,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.pte.reading' => ['required_if:isPTE,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.pte.writing' => ['required_if:isPTE,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.pte.score' => ['required_if:isPTE,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.pte.date' => ['required_if:isPTE,true', 'nullable', 'date'],
            'englishLanguage.pte.additional' => ['required_if:isPTE,true', 'nullable', 'string'],
            'englishLanguage.pte.file' => ['required_if:isPTE,true', 'nullable', 'file'],
//            English Language GMAT
            'englishLanguage.gmat' => ['array', 'required_array_keys:listening,reading,speaking,writing,score,date,additional,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['listening', 'reading', 'speaking', 'writing', 'score', 'date', 'additional', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'englishLanguage.gmat.listening' => ['required_if:isGMAT,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.gmat.speaking' => ['required_if:isGMAT,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.gmat.reading' => ['required_if:isGMAT,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.gmat.writing' => ['required_if:isGMAT,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.gmat.score' => ['required_if:isGMAT,true', 'nullable', 'decimal:0,1'],
            'englishLanguage.gmat.date' => ['required_if:isGMAT,true', 'nullable', 'date'],
            'englishLanguage.gmat.additional' => ['required_if:isGMAT,true', 'nullable', 'string'],
            'englishLanguage.gmat.file' => ['required_if:isGMAT,true', 'nullable', 'file'],

            //English Language OTHERS
            'englishLanguage.others' => ['nullable', 'array'],
            'englishLanguage.others.info' => ['nullable', 'string'],
                'englishLanguage.others.file' => ['required_with:englishLanguage.others.info', 'nullable', 'file'],

            //Work Experience
            'workExperience' => ['nullable', 'array'],
            'workExperience.*.employer' => ['nullable', 'string'],
            'workExperience.*.position' => ['nullable', 'string'],
            'workExperience.*.period' => ['nullable', 'string'],
            'workExperience.*.responsibilities' => ['nullable', 'string'],
            'workExperience.*.file' => ['nullable', 'file'],

            //References
            'references' => ['nullable', 'array'],
            'references.*.name' => ['nullable', 'string'],
            'references.*.designation' => ['nullable', 'string'],
            'references.*.institution' => ['nullable', 'string'],
            'references.*.email' => ['nullable', 'string'],
            'references.*.phone' => ['nullable', 'string'],
            'references.*.address' => ['nullable', 'string'],
            'references.*.city' => ['nullable', 'string'],
            'references.*.state' => ['nullable', 'string'],
            'references.*.country' => ['nullable', 'string'],
            'references.*.zip' => ['nullable', 'string'],

            //Statement of Purpose
            'statementOfPurpose' => ['nullable', 'array', 'required_array_keys:sop,file', function ($attribute, $value, $fail) {
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
            'medicalHistory' => ['required_if:isMedicalRequired,true', 'nullable', 'string'],

            //Additional Information
            'additionalInformation' => ['nullable', 'string'],

            //Additional Documents
            'additionalDocuments' => ['nullable', 'array'],
            'additionalDocuments.*.title' => ['nullable', 'string'],
            'additionalDocuments.*.file' => ['nullable', 'file'],
            //Lead Id
            'leadId' => ['required', 'exists:leads,id'],

            //CountryId, CourseId, InstitutionId
            'choices' => ['nullable', 'array'],
            'choices.*.countryId' => ['nullable', 'exists:representing_countries,id'],
            'choices.*.institutionId' => ['required_with:choices.*.countryId', 'exists:representing_institutions,id'],
            'choices.*.courseId' => ['required_with:choices.*.countryId', 'exists:courses,id'],
        ];
    }

}
