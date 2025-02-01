<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DuplicateApplicationResource extends JsonResource
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
            'studentFirstName' => $this->resource->student_first_name,
            'studentLastName' => $this->resource->student_last_name,
            'studentReference' => $this->resource->student_reference,
            'course' => CourseResource::make($this->whenLoaded('course')),
        ];
    }


    /**
     * Check if the application has duplicates.
     */

}
