<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Api\DateResource;
use App\Models\RepresentingInstitution;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'branch' => BranchResource::make($this->whenLoaded('branch')),
            'counsellors' => CounsellorResource::collection($this->whenLoaded('counsellors')),
            'associate' => CounsellorResource::make($this->whenLoaded('associate')),
            'studentFirstName' => $this->resource->student_first_name,
            'studentLastName' => $this->resource->student_last_name,
            'intakeOfInterestMonth' => $this->resource->intake_of_interest_month,
            'intakeOfInterestYear' => $this->resource->intake_of_interest_year,
            'studentEmail' => $this->resource->student_email,
            'studentPhone' => $this->resource->student_phone,
            'studentEmergencyPhone' => $this->resource->student_emergency_phone,
            'studentMobile' => $this->resource->student_mobile,
            'studentSkype' => $this->resource->student_skype,
            'courseLevelOfInterest' => $this->resource->course_level_of_interest,
            'dateOfBirth' => $this->resource->date_of_birth ?  ['date' => $this->resource->date_of_birth, 'age' => $this->resource->date_of_birth->age] : null,
            'isCountryPreferred' => $this->resource->is_country_preferred,
            'isApplicationGenerated' => $this->resource->is_application_generated,
            'leadSource' => LeadSourceResource::make(
                $this->whenLoaded('leadSource')
            ),
            'interestedCountry' => $this->interested_country_id ? CountryResource::make($this->whenLoaded('interestedCountry')) : null,
            'interestedInstitution' => $this->interested_institution_id ? RepresentingInstitutionResource::make($this->whenLoaded('interestedInstitution')) : null,
            'institutionName' => $this->resource->institution_name,
            'status' => $this->resource->status,
            $this->mergeWhen($request->routeIs('leads.*'), [
                'estimatedBudget' => $this->resource->estimated_budget,
                'additionalInfo' => $this->resource->additional_info,
                'courseCategory' => json_decode($this->resource->course_category),
                'followups' => FollowupResource::collection($this->whenLoaded('followups')),
                'quotations' => QuotationResource::collection($this->whenLoaded('quotations')),
                'addedBy' => $this->addedBy->name,
                'createdAt' => DateResource::make(
                    $this->resource->created_at
                ),
                'updatedAt' => DateResource::make(
                    $this->resource->updated_at
                ),
            ])
        ];
    }
}
