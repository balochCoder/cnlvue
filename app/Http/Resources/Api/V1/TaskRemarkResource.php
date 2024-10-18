<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskRemarkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'remark' => $this->resource->remark,
            'task' => TaskResource::make($this->whenLoaded('task')),
            'createdBy' => $this->resource->createdBy->name,
            'createdAt' => $this->resource->created_at,
        ];
    }
}
