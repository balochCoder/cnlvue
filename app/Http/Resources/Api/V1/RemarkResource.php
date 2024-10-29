<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Api\DateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RemarkResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'remarks' => $this->resource->remarks,
            'addDate' => $this->resource->add_date,
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
