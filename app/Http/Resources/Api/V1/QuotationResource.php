<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Api\DateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'lead' => LeadResource::make($this->whenLoaded('lead')),
            'studentImage' => $this->resource->student_image,
            'studentTitle' => $this->resource->student_title,
            'studentGender' => $this->resource->student_gender,
            'studentMaritalStatus' => $this->resource->student_marital_status,
            'isValidPassport' => $this->resource->is_valid_passport,
            'studentPassport' => $this->resource->student_passport,
            'studentNationality' => $this->resource->student_nationality,
            'permanentAddress' => json_decode($this->resource->permanent_address),
            'correspondenceAddress' => json_decode($this->resource->correspondence_address),
            'educationHistory' => json_decode($this->resource->education_history),
            "englishLanguage" => json_decode($this->resource->english_language),
            'workExperience' => json_decode($this->resource->work_experience),
            'references' => json_decode($this->resource->references),
            'statementOfPurpose' => json_decode($this->resource->statement_of_purpose),
            'additionalDocuments' => json_decode($this->resource->additional_documents),
            'isAccommodationRequired' => $this->resource->is_accommodation_required,
            'isMedicalRequired' => $this->resource->is_medical_required,
            'medicalHistory' => $this->resource->medical_history,
            'additionalInformation' => $this->resource->additional_information,
            'addedBy' => $this->resource->addedBy->name,
            'createdAt' => DateResource::make(
                $this->resource->created_at,
            ),
            'updatedAt' => DateResource::make(
                $this->resource->updated_at,
            )
        ];
    }
}
