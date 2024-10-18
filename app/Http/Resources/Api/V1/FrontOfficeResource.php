<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Api\DateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FrontOfficeResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return[
            'id' => $this->resource->id,
            'branch'=>BranchResource::make($this->whenLoaded('branch')),
            'editLeads' => $this->resource->edit_leads,
            'user' => UserResource::make($this->whenLoaded('user')),
            'isActive' => $this->resource->is_active,
            'createdAt' => DateResource::make(
                $this->resource->created_at
            ),
            'updatedAt' => DateResource::make(
                $this->resource->updated_at
            ),
        ];
    }
}
