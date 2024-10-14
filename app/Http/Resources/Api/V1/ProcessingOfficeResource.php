<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProcessingOfficeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->resource->id,
            'name'=> $this->resource->name,
            $this->mergeWhen($request->routeIs('processing-offices.*'),[
                'address'=> $this->resource->address,
                'city'=> $this->resource->city,
                'state'=> $this->resource->state,
                'country' => CountryResource::make($this->whenLoaded('country')),
                'timeZone'=> TimeZoneResource::make($this->whenLoaded('timeZone')),
                'officePhone'=> $this->resource->office_phone,

                'isActive'=> $this->resource->is_active,

                'user' => UserResource::make($this->whenLoaded('user')),
                'createdAt' => $this->resource->created_at,
            ])
        ];
    }
}
