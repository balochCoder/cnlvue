<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FrontOfficeResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return[
            'id' => $this->resource->id,
            'branch'=>BranchResource::make($this->whenLoaded('branch')),
            'edit_leads' => $this->resource->edit_leads,
            'user' => UserResource::make($this->whenLoaded('user')),
            'is_active' => $this->resource->is_active,
            'created_at' => $this->resource->created_at,
        ];
    }
}
