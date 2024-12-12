<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Api\DateResource;
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
            "visaRequirements" => $this->resource->visa_requirements,
            "countryBenefits" => $this->resource->country_benefits,
            "isActive" => $this->resource->is_active,

            $this->mergeWhen(
                $request->routeIs('representing-countries.*'),
                [

                    "monthlyLivingCost" => $this->resource->monthly_living_cost,

                    "partTimeWorkDetails" => $this->resource->part_time_work_details,

                    'applicationProcesses' => ApplicationProcessResource::collection($this->whenLoaded('applicationProcesses')),
                    'representingInstitutions' => RepresentingInstitutionResource::collection($this->whenLoaded('representingInstitutions')),
                    'createdAt' => DateResource::make(
                        $this->resource->created_at
                    ),
                    'updatedAt' => DateResource::make(
                        $this->resource->updated_at
                    ),
                ]
            ),

        ];
    }


}
