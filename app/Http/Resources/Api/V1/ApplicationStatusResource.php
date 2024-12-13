<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationStatusResource extends JsonResource
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
            'applicationProcess' => ApplicationProcessResource::make($this->whenLoaded('applicationProcess')),
            'subStatus' => SubStatusResource::make($this->whenLoaded('subStatus')),
            'document' => $this->resource->document,
            'additionalNotes' => $this->resource->additional_notes,
            'createdAt' => $this->resource->created_at,
            'updatedAt' => $this->resource->updated_at,

        ];
    }
}
