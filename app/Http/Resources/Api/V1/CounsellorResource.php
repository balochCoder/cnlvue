<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CounsellorResource extends JsonResource
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
            'branch' => BranchResource::make($this->whenLoaded('branch')),
            'isProcessingOfficer' => $this->resource->is_processing_officer,
            'user' => UserResource::make($this->whenLoaded('user')),
            'isActive' => $this->resource->is_active,
            'createdAt' => $this->resource->created_at,
        ];
    }
}
