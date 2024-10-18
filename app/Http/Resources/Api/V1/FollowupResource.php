<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowupResource extends JsonResource
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
            'remarks' => $this->resource->remarks,
            'leadType' => $this->resource->lead_type,
            'followUpMode' => $this->resource->follow_up_mode,
            'followUpDate' => $this->resource->follow_up_date,
            'time' => $this->resource->time,
            'lead' => LeadResource::make($this->whenLoaded('lead')),
            'addedBy' => $this->resource->addedBy->name,
            'createdAt' => $this->resource->created_at,
            'updatedAt' => $this->resource->updated_at,
        ];
    }
}
