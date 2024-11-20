<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Api\DateResource;
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
            'representingCountry'=> $this->resource->representingCountry->id ?? null,
            $this->mergeWhen(
                $request->routeIs('countries.*'), [
                    'isActive' => $this->resource->is_active,

                    'createdAt' => DateResource::make(
                        $this->resource->created_at
                    ),
                    'updatedAt' => DateResource::make(
                        $this->resource->updated_at
                    ),
                ]
            )
        ];
    }
}
