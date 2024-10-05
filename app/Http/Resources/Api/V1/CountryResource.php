<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            'name' => $this->resource->name,
            'flag' => asset($this->resource->flag),
            $this->mergeWhen(
                $request->routeIs('countries.*'), [
                    'isActive' => !!$this->resource->is_active,

                    'createdAt' => $this->resource->created_at,
                    'updatedAt' => $this->resource->updated_at,
                ]
            )
        ];
    }
}
