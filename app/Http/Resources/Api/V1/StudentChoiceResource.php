<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentChoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'country' => RepresentingCountryResource::make($this->whenLoaded('country')),
            'institution' => RepresentingInstitutionResource::make($this->whenLoaded('institution')),
            'course' => CourseResource::make($this->whenLoaded('course')),
        ];
    }
}
