<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Api\DateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'studentFirstName' => $this->resource->student_first_name,
            'studentLastName' => $this->resource->student_last_name,
            'studentReference' => $this->resource->student_reference,
            'tasks'=>TaskResource::collection($this->whenLoaded('tasks')),
            $this->mergeWhen($request->routeIs('applications.*'), [
                'adminNotes' => ApplicationAdminNoteResource::collection($this->whenLoaded('adminNotes')),
                'followups' => FollowupResource::collection($this->whenLoaded('followups')),
                'followupsCount' => $this->followupsCountByMode ?? [],
                'student' => StudentResource::make($this->whenLoaded('student')),
                'course' => CourseResource::make($this->whenLoaded('course')),
                'currency' => CurrencyResource::make($this->whenLoaded('currency')),
                'leadSource' => LeadSourceResource::make($this->whenLoaded('leadSource')),
                'counsellor' => CounsellorResource::make($this->whenLoaded('counsellor')),
                'applicationStatuses' => ApplicationStatusResource::collection($this->whenLoaded('applicationStatuses')),
                'associate' => AssociateResource::make($this->whenLoaded('associate')),
                'studentGender' => $this->resource->student_gender,
                'studentTitle' => $this->resource->student_title,
                'studentMaritalStatus' => $this->resource->student_marital_status,
                'studentEmail' => $this->resource->student_email,
                'dateOfBirth' => $this->resource->date_of_birth,
                'studentPhone' => $this->resource->student_phone,
                'studentMobile' => $this->resource->student_mobile,
                'studentSkype' => $this->resource->student_skype,
                'studentNationality' => $this->resource->student_nationality,
                'isValidPassport' => $this->resource->is_valid_passport,
                'passportIssueDate' => $this->resource->passport_issue_date,
                'passportExpiryDate' => $this->resource->passport_expiry_date,
                'studentPassport' => $this->resource->student_passport,
                'studentImage' => $this->resource->student_image,
                'intakeMonth' => $this->resource->intake_month,
                'intakeYear' => $this->resource->intake_year,
                'applicationFee' => $this->resource->application_fee,
                'applicationPaymentMethod' => $this->resource->application_payment_method,
                'applicationPaymentDate' => $this->resource->application_payment_date,
                'applicationPaymentReference' => $this->resource->application_payment_reference,
                'scholarshipOffered' => $this->resource->scholarship_offered,
                'scholarshipProof' => $this->resource->scholarship_proof,
                'totalTutionFeeToBePaid' => $this->resource->total_tution_fee_to_be_paid,
                'feePaidSoFar' => $this->resource->fee_paid_so_far,
                'firstYearFeeDue' => $this->resource->first_year_fee_due,
                'totalFeeDue' => $this->resource->total_fee_due,
                'feePaymentMethod' => $this->resource->fee_payment_method,
                'feePaymentDate' => $this->resource->fee_payment_date,
                'feePaymentReference' => $this->resource->fee_payment_reference,
                'applicationRemarks' => $this->resource->application_remarks,
                'isMedicalRequired' => $this->resource->is_medical_required,
                'medicalHistory' => $this->resource->medical_history,
                'additionalInformation' => $this->resource->additional_information,
                'permanentAddress' => json_decode($this->resource->permanent_address),
                'correspondenceAddress' => json_decode($this->resource->correspondence_address),
                'educationHistory' => json_decode($this->resource->education_history),
                'englishLanguage' => json_decode($this->resource->english_language),
                'workExperience' => json_decode($this->resource->work_experience),
                'references' => json_decode($this->resource->references),
                'statementOfPurpose' => json_decode($this->resource->statement_of_purpose),
                'additionalDocuments' => json_decode($this->resource->additional_documents),
                'isAccommodationRequired' => $this->resource->is_accommodation_required,
                'institutionReference'=> $this->resource->institution_reference,
                'addedBy' => $this->resource->addedBy->name,
                'createdAt' => DateResource::make(
                    $this->resource->created_at,
                ),
                'updatedAt' => DateResource::make(
                    $this->resource->updated_at,
                )
            ])
        ];
    }
}
