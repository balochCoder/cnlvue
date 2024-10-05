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
            'name' => $this->resource->name,
            'phone' => $this->resource->phone,
            'mobile' => $this->resource->mobile,
            'whatsapp' => $this->resource->whatsapp,
            'download_csv' => $this->resource->download_csv,
            'is_processing_officer' => $this->resource->is_processing_officer,
            'user' => UserResource::make($this->whenLoaded('user')),
            'is_active' => $this->resource->is_active,
            'created_at' => $this->resource->created_at,
        ];
    }
}
