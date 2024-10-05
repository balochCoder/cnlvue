<?php

namespace App\Http\Resources\Api\V1;

use App\Enums\CourseLevel;
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
            'representing_institution_id' => $this->resource->representing_institution_id,
            'title' => $this->resource->title,
            'level' => [
                'key' => $this->resource->level,
                'value' => $this->resource->level->getLabel(),
            ],
            'duration' => $this->resource->duration,
            'start_date' => $this->resource->start_date,
            'end_date' => $this->resource->end_date,
            'campus' => $this->resource->campus,
            'awarding_body' => $this->resource->awarding_body,
            'fee' => $this->resource->fee,
            'part_time_work_details' => $this->resource->part_time_work_details,
            'application_fee' => $this->resource->application_fee,
            'currency' => CurrencyResource::make($this->whenLoaded('currency')),
            'monthly_living_cost' => $this->resource->monthly_living_cost,
            'course_benefits' => $this->resource->course_benefits,
            'general_eligibility' => $this->resource->general_eligibility,
            'quality_of_applicant' => $this->resource->quality_of_applicant,
            'is_language' => (string)$this->resource->is_language,
            'language_requirements'=> $this->resource->language_requirements,
            'course_category'=> $this->resource->course_category,
            'document_1_title' => $this->resource->document_1_title,
            'document_1' => $this->resource->document_1,
            'document_2_title' => $this->resource->document_2_title,
            'document_2' => $this->resource->document_2,
            'document_3_title' => $this->resource->document_3_title,
            'document_3' => $this->resource->document_3,
            'document_4_title' => $this->resource->document_4_title,
            'document_4' => $this->resource->document_4,
            'document_5_title' => $this->resource->document_5_title,
            'document_5' => $this->resource->document_5,
            'modules' => $this->resource->modules,
            'intake' => $this->resource->intake,
            'is_active' => $this->resource->is_active,
        ];
    }
}
