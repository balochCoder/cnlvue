<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->resource->title,
            'file' => $this->resource->file,
            'description' => $this->resource->description,
            'status' => $this->resource->status,
            'assignedTo' => UserResource::make($this->whenLoaded('assignedTo')),
            'assignedBy' => UserResource::make($this->whenLoaded('assignedBy')),
            'startDate' => $this->resource->start_date,
            'dueDate' => $this->resource->due_date,
            'remarks' => TaskRemarkResource::collection($this->whenLoaded('remarks')),
            'createdAt' => $this->resource->created_at,
            'updatedAt' => $this->resource->updated_at,
        ];
    }
}
