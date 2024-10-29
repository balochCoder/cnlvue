<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Api\DateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TargetResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'description' => $this->resource->description,
            'year' => $this->resource->year,
            'number' => $this->resource->number,
            'counsellor'=>CounsellorResource::make($this->whenLoaded('counsellor')),
            'addedBy' => UserResource::make($this->resource->addedBy),
            'createdAt' => DateResource::make(
                $this->resource->created_at
            ),
            'updatedAt' => DateResource::make(
                $this->resource->updated_at
            ),
        ];
    }
}
