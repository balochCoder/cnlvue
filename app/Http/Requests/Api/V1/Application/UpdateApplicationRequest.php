<?php

namespace App\Http\Requests\Api\V1\Application;


class UpdateApplicationRequest extends BaseApplicationRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'studentFirstName' => ['required', 'string', 'min:2', 'max:255'],
            'studentLastName' => ['required', 'string', 'min:2', 'max:255'],
            'studentPhone' => ['nullable', 'string'],
            'studentEmail' => ['nullable', 'email', 'string'],
            'studentMobile' => ['nullable', 'string'],
            'studentNationality' => ['required', 'string'],
            'studentPassport' => ['required_if:isValidPassport,true', 'nullable','string'],
            'studentImage' => ['sometimes', 'nullable'],
            'intakeMonth' => ['nullable', 'string'],
            'intakeYear' => ['nullable', 'string'],

            'applicationPaymentMethod' => ['nullable', 'string'],
            'applicationPaymentReference' => ['nullable', 'string'],
            'scholarshipOffered' => ['nullable', 'numeric'],
            'scholarshipProof' => ['sometimes', 'nullable'],
            'feePaymentMethod' => ['nullable', 'string'],
            'feePaymentReference' => ['nullable', 'string'],
            'applicationRemarks' => ['nullable', 'string'],

            'dateOfBirth' => ['required', 'date'],
            'applicationPaymentDate' => ['nullable', 'date'],
            'feePaymentDate' => ['nullable', 'date'],
            'passportIssueDate' => ['nullable', 'date'],
            'passportExpiryDate' => ['nullable', 'date'],

            'medicalHistory' => ['required_if:isMedicalRequired,true', 'nullable','string'],
            'additionalInformation' => ['nullable', 'string'],

            'applicationFee' => ['nullable', 'numeric'],
            'totalTuitionFeeToBePaid' => ['nullable', 'numeric'],
            'feePaidSoFar' => ['nullable', 'numeric'],
            'firstYearFeeDue' => ['nullable', 'numeric'],
            'totalFeeDue' => ['nullable', 'numeric'],


            //Permanent Address
            'permanentAddress' => ['nullable', 'array', 'required_array_keys:address,city,state,country', function ($attribute, $value, $fail) {
                $allowedKeys = ['address', 'city', 'state', 'country'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            //Correspondance Address
            'correspondenceAddress' => ['nullable', 'array', 'required_array_keys:address,city,state,country', function ($attribute, $value, $fail) {
                $allowedKeys = ['address', 'city', 'state', 'country'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
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
            'englishLanguage.ielts.listening' => ['nullable', 'decimal:0,1'],
            'englishLanguage.ielts.speaking' => ['nullable', 'decimal:0,1'],
            'englishLanguage.ielts.reading' => ['nullable', 'decimal:0,1'],
            'englishLanguage.ielts.writing' => ['nullable', 'decimal:0,1'],
            'englishLanguage.ielts.score' => ['nullable', 'decimal:0,1'],
            'englishLanguage.ielts.date' => ['nullable', 'date'],
            'englishLanguage.ielts.additional' => ['nullable', 'string'],
            'englishLanguage.ielts.file' => ['sometimes', 'nullable'],

            //English Language TOEFL
            'englishLanguage.toefl' => ['array', 'required_array_keys:listening,reading,speaking,writing,score,date,additional,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['listening', 'reading', 'speaking', 'writing', 'score', 'date', 'additional', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'englishLanguage.toefl.listening' => ['nullable', 'decimal:0,1'],
            'englishLanguage.toefl.speaking' => ['nullable', 'decimal:0,1'],
            'englishLanguage.toefl.reading' => ['nullable', 'decimal:0,1'],
            'englishLanguage.toefl.writing' => ['nullable', 'decimal:0,1'],
            'englishLanguage.toefl.score' => ['nullable', 'decimal:0,1'],
            'englishLanguage.toefl.date' => ['nullable', 'date'],
            'englishLanguage.toefl.additional' => ['nullable', 'string'],
            'englishLanguage.toefl.file' => ['sometimes','nullable'],
            //English Language PTE
            'englishLanguage.pte' => ['array', 'required_array_keys:listening,reading,speaking,writing,score,date,additional,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['listening', 'reading', 'speaking', 'writing', 'score', 'date', 'additional', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'englishLanguage.pte.listening' => ['nullable', 'decimal:0,1'],
            'englishLanguage.pte.speaking' => ['nullable', 'decimal:0,1'],
            'englishLanguage.pte.reading' => ['nullable', 'decimal:0,1'],
            'englishLanguage.pte.writing' => ['nullable', 'decimal:0,1'],
            'englishLanguage.pte.score' => ['nullable', 'decimal:0,1'],
            'englishLanguage.pte.date' => ['nullable', 'date'],
            'englishLanguage.pte.additional' => ['nullable', 'string'],
            'englishLanguage.pte.file' => ['sometimes', 'nullable'],
            //English Language GMAT
            'englishLanguage.gmat' => ['array', 'required_array_keys:listening,reading,speaking,writing,score,date,additional,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['listening', 'reading', 'speaking', 'writing', 'score', 'date', 'additional', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'englishLanguage.gmat.listening' => ['nullable', 'decimal:0,1'],
            'englishLanguage.gmat.speaking' => ['nullable', 'decimal:0,1'],
            'englishLanguage.gmat.reading' => ['nullable', 'decimal:0,1'],
            'englishLanguage.gmat.writing' => ['nullable', 'decimal:0,1'],
            'englishLanguage.gmat.score' => ['nullable', 'decimal:0,1'],
            'englishLanguage.gmat.date' => ['nullable', 'date'],
            'englishLanguage.gmat.additional' => ['nullable', 'string'],
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
            //Additional Documents
            'additionalDocuments' => ['nullable', 'array'],
            'additionalDocuments.*.title' => ['nullable', 'string'],
            'additionalDocuments.*.file' => ['sometimes','nullable'],

            'studentGender' => ['required', 'string', 'in:Male,Female'],
            'studentTitle' => ['required', 'string', 'in:Mr,Mrs,Ms,Miss'],
            'studentMaritalStatus' => ['required', 'string', 'in:Married,Single'],
            'isValidPassport' => ['required', 'boolean'],
            //Is Accomodation Required
            'isAccommodationRequired' => ['required', 'boolean'],
            //Is Medical Required
            'isMedicalRequired' => ['required', 'boolean'],


            'courseId' => ['nullable', 'integer', 'exists:courses,id'],
            'currencyId' => ['required', 'integer', 'exists:currencies,id'],
            'leadSourceId' => ['required', 'integer', 'exists:lead_sources,id'],
            'associateId' => ['required_if:leadSourceId,1', 'nullable','integer', 'exists:associates,id'],
        ];
    }


}
