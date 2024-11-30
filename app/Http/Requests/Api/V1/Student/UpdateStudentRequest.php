<?php

namespace App\Http\Requests\Api\V1\Student;


class UpdateStudentRequest extends BaseStudentRequest
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
            'studentPassport' => ['required_if:isValidPassport,true', 'nullable','string'],
            'studentPhone' => ['nullable', 'string'],
            'studentEmail' => ['nullable', 'email', 'string'],
            'studentMobile' => ['nullable', 'string'],
            'studentImage' => ['sometimes', 'nullable'],
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

            'isIELTS' => ['boolean'],
            'isTOEFL' => ['boolean'],
            'isPTE' => ['boolean'],
            'isGMAT' => ['boolean'],

            //Education History
            'educationHistory' => ['nullable', 'array'],
            'educationHistory.*.institution' => ['sometimes',  'nullable','string'],
            'educationHistory.*.qualification' => ['sometimes', 'nullable', 'string'],
            'educationHistory.*.year' => ['sometimes', 'nullable', 'integer'],
            'educationHistory.*.grade' => ['sometimes', 'nullable','string'],
            'educationHistory.*.file' => ['sometimes', 'nullable'],

            //English Language
            'englishLanguage' => ['nullable', 'array'],
            //English Language IELTS
            'englishLanguage.ielts' => ['array', 'required_array_keys:listening,reading,speaking,writing,score,date,additional,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['listening', 'reading', 'speaking', 'writing', 'score', 'date', 'additional', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'englishLanguage.ielts.listening' => ['required_if:isIELTS,true','nullable', 'decimal:0,1'],
            'englishLanguage.ielts.speaking' => ['required_if:isIELTS,true','nullable', 'decimal:0,1'],
            'englishLanguage.ielts.reading' => ['required_if:isIELTS,true','nullable', 'decimal:0,1'],
            'englishLanguage.ielts.writing' => ['required_if:isIELTS,true','nullable', 'decimal:0,1'],
            'englishLanguage.ielts.score' => ['required_if:isIELTS,true','nullable', 'decimal:0,1'],
            'englishLanguage.ielts.date' => ['required_if:isIELTS,true','nullable', 'date'],
            'englishLanguage.ielts.additional' => ['required_if:isIELTS,true','nullable', 'string'],
            'englishLanguage.ielts.file' => ['sometimes', 'nullable'],

            //English Language TOEFL
            'englishLanguage.toefl' => ['array', 'required_array_keys:listening,reading,speaking,writing,score,date,additional,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['listening', 'reading', 'speaking', 'writing', 'score', 'date', 'additional', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'englishLanguage.toefl.listening' => ['required_if:isTOEFL,true','nullable', 'decimal:0,1'],
            'englishLanguage.toefl.speaking' => ['required_if:isTOEFL,true','nullable', 'decimal:0,1'],
            'englishLanguage.toefl.reading' => ['required_if:isTOEFL,true','nullable', 'decimal:0,1'],
            'englishLanguage.toefl.writing' => ['required_if:isTOEFL,true','nullable', 'decimal:0,1'],
            'englishLanguage.toefl.score' => ['required_if:isTOEFL,true','nullable', 'decimal:0,1'],
            'englishLanguage.toefl.date' => ['required_if:isTOEFL,true','nullable', 'date'],
            'englishLanguage.toefl.additional' => ['required_if:isTOEFL,true','nullable', 'string'],
            'englishLanguage.toefl.file' => ['sometimes','nullable'],
            //English Language PTE
            'englishLanguage.pte' => ['array', 'required_array_keys:listening,reading,speaking,writing,score,date,additional,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['listening', 'reading', 'speaking', 'writing', 'score', 'date', 'additional', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'englishLanguage.pte.listening' => ['required_if:isPTE,true','nullable', 'decimal:0,1'],
            'englishLanguage.pte.speaking' => ['required_if:isPTE,true','nullable', 'decimal:0,1'],
            'englishLanguage.pte.reading' => ['required_if:isPTE,true','nullable', 'decimal:0,1'],
            'englishLanguage.pte.writing' => ['required_if:isPTE,true','nullable', 'decimal:0,1'],
            'englishLanguage.pte.score' => ['required_if:isPTE,true','nullable', 'decimal:0,1'],
            'englishLanguage.pte.date' => ['required_if:isPTE,true','nullable', 'date'],
            'englishLanguage.pte.additional' => ['required_if:isPTE,true','nullable', 'string'],
            'englishLanguage.pte.file' => ['sometimes', 'nullable'],
//            English Language GMAT
            'englishLanguage.gmat' => ['array', 'required_array_keys:listening,reading,speaking,writing,score,date,additional,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['listening', 'reading', 'speaking', 'writing', 'score', 'date', 'additional', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'englishLanguage.gmat.listening' => ['required_if:isGMAT,true','nullable', 'decimal:0,1'],
            'englishLanguage.gmat.speaking' => ['required_if:isGMAT,true','nullable', 'decimal:0,1'],
            'englishLanguage.gmat.reading' => ['required_if:isGMAT,true','nullable', 'decimal:0,1'],
            'englishLanguage.gmat.writing' => ['required_if:isGMAT,true','nullable', 'decimal:0,1'],
            'englishLanguage.gmat.score' => ['required_if:isGMAT,true','nullable', 'decimal:0,1'],
            'englishLanguage.gmat.date' => ['required_if:isGMAT,true','nullable', 'date'],
            'englishLanguage.gmat.additional' => ['required_if:isGMAT,true','nullable', 'string'],
            'englishLanguage.gmat.file' => ['sometimes', 'nullable'],

            //English Language OTHERS
            'englishLanguage.others' => ['nullable', 'array'],
            'englishLanguage.others.info' => ['nullable', 'string'],
            'englishLanguage.others.file' => ['sometimes', 'nullable'],

            //Work Experience
            'workExperience' => ['nullable', 'array'],
            'workExperience.*.employer' => ['sometimes','nullable', 'string'],
            'workExperience.*.position' => ['sometimes','nullable', 'string'],
            'workExperience.*.period' => ['sometimes','nullable', 'string'],
            'workExperience.*.responsibilities' => ['sometimes','nullable', 'string'],
            'workExperience.*.file' => ['sometimes','nullable'],

            //References
            'references' => ['nullable', 'array'],
            'references.*.name' => ['sometimes','nullable', 'string'],
            'references.*.designation' => ['sometimes','nullable', 'string'],
            'references.*.institution' => ['sometimes','nullable', 'string'],
            'references.*.email' => ['sometimes','nullable', 'string'],
            'references.*.phone' => ['sometimes','nullable', 'string'],
            'references.*.address' => ['sometimes','nullable', 'string'],
            'references.*.city' => ['sometimes','nullable', 'string'],
            'references.*.state' => ['nullable', 'string'],
            'references.*.country' => ['sometimes','nullable', 'string'],
            'references.*.zip' => ['nullable', 'string'],

            //Statement of Purpose
            'statementOfPurpose' => ['nullable', 'array', 'required_array_keys:sop,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['sop', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'statementOfPurpose.sop' => ['nullable', 'string'],
            'statementOfPurpose.file' => ['nullable', 'sometimes'],

            //Is Accomodation Required
            'isAccommodationRequired' => ['required', 'boolean'],

            //Is Medica lRequired
            'isMedicalRequired' => ['required', 'boolean'],
            'medicalHistory' => ['required_if:isMedicalRequired,true', 'nullable','string'],

            //Additional Information
            'additionalInformation' => ['nullable', 'string'],

            //Additional Documents
            'additionalDocuments' => ['nullable', 'array'],
            'additionalDocuments.*.title' => ['nullable', 'string'],
            'additionalDocuments.*.file' => ['sometimes','nullable'],
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
