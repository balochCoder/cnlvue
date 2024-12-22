<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Api\DateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RepresentingInstitutionResource extends JsonResource
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
            'name' => $this->resource->name,
            'isActive' => !!$this->resource->is_active,
            'representingCountry' => RepresentingCountryResource::make($this->whenLoaded('representingCountry')),
            'courses' => CourseResource::collection($this->whenLoaded('courses')),
            'institutionalBenefits' => $this->resource->institutional_benefits,
            'fundsRequired' => $this->resource->funds_required,
            'institutionStatusNotes' => $this->resource->institution_status_notes,

            $this->mergeWhen($request->routeIs('representing-institutions.*'),[

                'type' => $this->resource->type,
                'campus' => $this->resource->campus,
                'website' => $this->resource->website,
                'monthlyLivingCost' => $this->resource->monthly_living_cost,
                'applicationFee' => $this->resource->application_fee,
                'currency' => CurrencyResource::make($this->whenLoaded('currency')),
                'contractTerm' => $this->resource->contract_term,
                'qualityOfApplicant' => $this->resource->quality_of_applicant,
                'contractCopy' => $this->resource->contract_copy,
                'contractExpiry' => $this->resource->contract_expiry,
                'isLanguage' => $this->resource->is_language,
                'languageRequirements' => $this->resource->language_requirements,
                'partTimeWorkDetails' => $this->resource->part_time_work_details,
                'scholarshipsPolicy' => $this->resource->scholarships_policy,
                'institutionStatusNotes' => $this->resource->institution_status_notes,
                'logo' => $this->resource->logo,
                'prospectus' => $this->resource->prospectus,
                'document1Title' => $this->resource->document_1_title,
                'document1' => $this->resource->document_1,
                'document2Title' => $this->resource->document_2_title,
                'document2' => $this->resource->document_2,
                'contactPersonName' => $this->resource->contact_person_name,
                'contactPersonEmail' => $this->resource->contact_person_email,
                'contactPersonPhone' => $this->resource->contact_person_phone,
                'contactPersonDesignation' => $this->resource->contact_person_designation,
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
