<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotationChoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'countryId' => $this->resource->country_id,
            'institutionId' => $this->resource->institution_id,
            'courseId' => $this->resource->course_id,
        ];
    }
}
