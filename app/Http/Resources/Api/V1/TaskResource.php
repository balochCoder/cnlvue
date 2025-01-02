<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Api\DateResource;
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
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'file' => $this->resource->file,
            'description' => $this->resource->description,
            'application' => ApplicationResource::make($this->whenLoaded('application')),
            'status' => $this->resource->status,
            'assignedTo' => UserResource::make($this->whenLoaded('assignedTo')),
            'assignedBy' => UserResource::make($this->whenLoaded('assignedBy')),
            'startDate' => DateResource::make(
                $this->resource->start_date
            ),
            'dueDate' => DateResource::make(
                $this->resource->due_date
            ),
            'remarks' => TaskRemarkResource::collection($this->whenLoaded('remarks')),
            'createdAt' => DateResource::make(
                $this->resource->created_at
            ),
            'updatedAt' => DateResource::make(
                $this->resource->updated_at
            ),
        ];
    }
}
