<?php

namespace App\Http\Requests\Api\V1\Application;


use App\Enums\PaymentMethodEnum;
use Illuminate\Validation\Rule;


class StoreApplicationRequest extends BaseApplicationRequest
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
            'studentEmail' => ['nullable', 'email', 'string'],
            'studentPhone' => ['nullable', 'string'],
            'studentMobile' => ['nullable', 'string'],

            'applicationRemarks' => ['nullable', 'string'],

            'studentNationality' => ['required', 'string'],
            'studentPassport' => ['required_if:isValidPassport,true', 'nullable', 'string'],
            'studentImage' => ['sometimes', 'nullable'],
            'intakeMonth' => ['nullable', 'string'],
            'intakeYear' => ['nullable', 'string'],

            'applicationPaymentMethod' => ['nullable', Rule::enum(PaymentMethodEnum::class)],
            'applicationPaymentReference' => ['nullable', 'string'],
            'scholarshipOffered' => ['nullable', 'numeric'],
            'scholarshipProof' => ['nullable', 'file', 'max:2048'],
            'feePaymentMethod' => ['nullable', Rule::enum(PaymentMethodEnum::class)],
            'feePaymentReference' => ['nullable', 'string'],

            'dateOfBirth' => ['required', 'date'],
            'applicationPaymentDate' => ['nullable', 'date'],
            'feePaymentDate' => ['nullable', 'date'],
            'passportIssueDate' => ['nullable', 'date'],
            'passportExpiryDate' => ['nullable', 'date'],

            'medicalHistory' => ['required_if:isMedicalRequired,true', 'nullable', 'string'],
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
            'educationHistory.*.institution' => ['nullable', 'string'],
            'educationHistory.*.qualification' => ['nullable', 'string'],
            'educationHistory.*.year' => ['nullable', 'integer'],
            'educationHistory.*.grade' => ['nullable', 'string'],
            'educationHistory.*.file' => ['nullable', 'sometimes'],

            //English Language
            'englishLanguage' => ['nullable', 'array'],
            //English Language IELTS
            'englishLanguage.ielts' => ['array', 'required_array_keys:listening,reading,speaking,writing,score,date,additional,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['listening', 'reading', 'speaking', 'writing', 'score', 'date', 'additional', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'englishLanguage.ielts.listening' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.ielts.speaking' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.ielts.reading' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.ielts.writing' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.ielts.score' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.ielts.date' => [ 'nullable', 'date'],
            'englishLanguage.ielts.additional' => [ 'nullable', 'string'],
            'englishLanguage.ielts.file' => [ 'nullable', 'sometimes'],
            //English Language TOEFL
            'englishLanguage.toefl' => ['array', 'required_array_keys:listening,reading,speaking,writing,score,date,additional,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['listening', 'reading', 'speaking', 'writing', 'score', 'date', 'additional', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'englishLanguage.toefl.listening' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.toefl.speaking' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.toefl.reading' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.toefl.writing' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.toefl.score' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.toefl.date' => [ 'nullable', 'date'],
            'englishLanguage.toefl.additional' => [ 'nullable', 'string'],
            'englishLanguage.toefl.file' => [ 'nullable', 'sometimes'],
            //English Language PTE
            'englishLanguage.pte' => ['array', 'required_array_keys:listening,reading,speaking,writing,score,date,additional,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['listening', 'reading', 'speaking', 'writing', 'score', 'date', 'additional', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'englishLanguage.pte.listening' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.pte.speaking' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.pte.reading' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.pte.writing' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.pte.score' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.pte.date' => [ 'nullable', 'date'],
            'englishLanguage.pte.additional' => [ 'nullable', 'string'],
            'englishLanguage.pte.file' => [ 'nullable', 'sometimes'],
            //English Language GMAT
            'englishLanguage.gmat' => ['array', 'required_array_keys:listening,reading,speaking,writing,score,date,additional,file', function ($attribute, $value, $fail) {
                $allowedKeys = ['listening', 'reading', 'speaking', 'writing', 'score', 'date', 'additional', 'file'];
                if (array_diff(array_keys($value), $allowedKeys)) {
                    $fail($attribute . ' contains invalid keys.');
                }
            }],
            'englishLanguage.gmat.listening' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.gmat.speaking' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.gmat.reading' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.gmat.writing' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.gmat.score' => [ 'nullable', 'decimal:0,1'],
            'englishLanguage.gmat.date' => [ 'nullable', 'date'],
            'englishLanguage.gmat.additional' => [ 'nullable', 'string'],
            'englishLanguage.gmat.file' => [ 'nullable', 'sometimes'],

            //English Language OTHERS
            'englishLanguage.others' => ['nullable', 'array'],
            'englishLanguage.others.info' => ['nullable', 'string'],
            'englishLanguage.others.file' => ['required_with:englishLanguage.others.info', 'nullable', 'sometimes'],

            //Work Experience
            'workExperience' => ['nullable', 'array'],
            'workExperience.*.employer' => ['nullable', 'string'],
            'workExperience.*.position' => ['nullable', 'string'],
            'workExperience.*.period' => ['nullable', 'string'],
            'workExperience.*.responsibilities' => ['nullable', 'string'],
            'workExperience.*.file' => ['nullable', 'sometimes'],

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
            'statementOfPurpose.file' => ['nullable', 'sometimes'],

            //Additional Documents
            'additionalDocuments' => ['nullable', 'array'],
            'additionalDocuments.*.title' => ['nullable', 'string'],
            'additionalDocuments.*.file' => ['nullable', 'sometimes'],

            'studentGender' => ['required', 'string', 'in:Male,Female'],
            'studentTitle' => ['required', 'string', 'in:Mr,Mrs,Ms,Miss'],
            'studentMaritalStatus' => ['required', 'string', 'in:Married,Single'],
            'isValidPassport' => ['required', 'boolean'],
            //Is Accomodation Required
            'isAccommodationRequired' => ['required', 'boolean'],
            //Is Medical Required
            'isMedicalRequired' => ['required', 'boolean'],


            'studentId' => ['nullable', 'integer', 'exists:students,id'],
            'courseId' => ['nullable', 'integer', 'exists:courses,id'],
            'currencyId' => ['required', 'integer', 'exists:currencies,id'],
            'leadSourceId' => ['required', 'integer', 'exists:lead_sources,id'],
            'associateId' => ['required_if:leadSourceId,1', 'nullable','integer', 'exists:associates,id'],
        ];
    }

}
