<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Api\DateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'title' => $this->resource->title,
            'representingInstitution' => RepresentingInstitutionResource::make($this->whenLoaded('representingInstitution')),

            $this->mergeWhen($request->routeIs('courses.*') || $request->routeIs('representingInstitutions.courses'),[
                'level' => $this->level,
                'duration' => json_decode($this->resource->duration),
                'startDate' => $this->resource->start_date,
                'endDate' => $this->resource->end_date,
                'campus' => $this->resource->campus,
                'awardingBody' => $this->resource->awarding_body,
                'fee' => $this->resource->fee,
                'partTimeWorkDetails' => $this->resource->part_time_work_details,
                'applicationFee' => $this->resource->application_fee,
                'currency' => CurrencyResource::make($this->whenLoaded('currency')),
                'monthlyLivingCost' => $this->resource->monthly_living_cost,
                'courseBenefits' => $this->resource->course_benefits,
                'generalEligibility' => $this->resource->general_eligibility,
                'qualityOfApplicant' => $this->resource->quality_of_applicant,
                'isLanguage' => $this->resource->is_language,
                'languageRequirements'=> $this->resource->language_requirements,
                'additionalInformation' => $this->resource->additional_information,
                'courseCategory'=> json_decode($this->resource->course_category),
                'document1Title' => $this->resource->document_1_title,
                'document1' => $this->resource->document_1,
                'document2Title' => $this->resource->document_2_title,
                'document2' => $this->resource->document_2,
                'document3Title' => $this->resource->document_3_title,
                'document3' => $this->resource->document_3,
                'document4Title' => $this->resource->document_4_title,
                'document4' => $this->resource->document_4,
                'document5Title' => $this->resource->document_5_title,
                'document5' => $this->resource->document_5,
                'modules' => json_decode($this->resource->modules),
                'intake' => json_decode($this->resource->intake),
                'isActive' => $this->resource->is_active,
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
