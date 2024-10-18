<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadSourceResource extends JsonResource
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
            'sourceName' => $this->resource->source_name,
            $this->mergeWhen($request->routeIs('lead-sources'), [
                'AddedBy' => $this->resource->user->name,
                'isActive' => $this->resource->is_active,
                'createdAt' => $this->resource->created_at,
                'updatedAt' => $this->resource->updated_at,
            ])
        ];
    }
}
