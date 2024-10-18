<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Api\DateResource;
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
            'isActive' => $this->resource->is_active,
            'user' => UserResource::make($this->resource->user),
            'branch' => BranchResource::make($this->whenLoaded('branch')),
            'isProcessingOfficer' => $this->resource->is_processing_officer,
            'remarks'=> RemarkResource::collection($this->whenLoaded('remarks')),
            'targets' => TargetResource::collection($this->whenLoaded('targets')),
            'createdAt' => DateResource::make(
                $this->resource->created_at
            ),
            'updatedAt' => DateResource::make(
                $this->resource->updated_at
            ),
        ];
    }
}
