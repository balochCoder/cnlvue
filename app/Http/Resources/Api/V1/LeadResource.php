<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'counsellors'=> CounsellorResource::collection($this->whenLoaded('counsellors')),
            'studentFirstName' => $this->resource->student_first_name,
            'studentLastName' => $this->resource->student_last_name,
            'intakeOfInterestMonths' => $this->resource->intake_of_interest_month,
            'intakeOfInterestYears' => $this->resource->intake_of_interest_year,
            'studentEmail' => $this->resource->student_email,
            'studentPhone' => $this->resource->student_phone,
            'studentEmergencyPhone' => $this->resource->student_emergency_phone,
            'studentMobile' => $this->resource->student_mobile,
            'studentSkype' => $this->resource->student_skype,
            'estimatedBudget' => $this->resource->estimated_budget,
            'courseLevelOfInterest' => $this->resource->course_level_of_interest,
            'additionalInfo' => $this->resource->additional_info,
            'courseCategory' => $this->resource->course_category,
            'dateOfBirth' => $this->resource->date_of_birth,
            'isCountryPreferred' => $this->resource->is_country_preferred,
            'isApplicationGenerated' => $this->resource->is_application_generated,
            'leadSource' => LeadSourceResource::make($this->whenLoaded('leadSource')),
            'interesetedCountry' => $this->interested_country_id ? $this->interestedCountry->name : null,
            'interesetedInstitution' => $this->interested_institution_id ? $this->interestedInstitution->name : null,
            'followups' => FollowupResource::collection($this->whenLoaded('followups')),
            'AddedBy' => $this->addedBy->name,
            'createdAt'=>$this->resource->created_at,
            'updatedAt'=>$this->resource->updated_at,
        ];
    }
}
