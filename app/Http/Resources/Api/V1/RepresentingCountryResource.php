<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RepresentingCountryResource extends JsonResource
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
            'country' => CountryResource::make($this->whenLoaded('country')),

            $this->mergeWhen(
                $request->routeIs('representing-countries.*'),
                [
                    "monthlyLivingCost" => $this->resource->monthly_living_cost,
                    "visaRequirements" => $this->resource->visa_requirements,
                    "partTimeWorkDetails" => $this->resource->part_time_work_details,
                    "countryBenefits" => $this->resource->country_benefits,
                    "isActive" => !!$this->resource->is_active,
                    'applicationProcess' => ApplicationProcessResource::collection($this->whenLoaded('applicationProcesses')),
                    'representingInstitutions' => RepresentingInstitutionResource::collection($this->whenLoaded('representingInstitutions')),
                    'createdAt' => $this->resource->created_at,
                    'updatedAt' => $this->resource->updated_at,
                ]
            ),

        ];
    }


}
