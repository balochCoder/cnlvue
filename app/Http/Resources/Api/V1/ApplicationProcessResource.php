<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationProcessResource extends JsonResource
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
            'notes' => $this->resource->notes,
            'isActive' => !!$this->resource->is_active,
            'order' => $this->resource->order,
            'subStatuses' => SubStatusResource::collection($this->whenLoaded('subStatuses')),
            'createdAt' => $this->resource->created_at,
            'updatedAt' => $this->resource->updated_at,

        ];
    }
}
