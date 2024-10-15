<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RemarkResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'remarks' => $this->resource->remarks,
            'date' => $this->resource->date,
            'counsellor'=>CounsellorResource::make($this->whenLoaded('counsellor')),
            'addedBy' => UserResource::make($this->resource->addedBy),
            'createdAt' => $this->resource->created_at,
            'updatedAt' => $this->resource->updated_at,
        ];
    }
}
