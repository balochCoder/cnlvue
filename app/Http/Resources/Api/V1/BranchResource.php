<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            $this->mergeWhen($request->routeIs('branches.*'),[
                'address'=> $this->resource->address,
                'city'=> $this->resource->city,
                'state'=> $this->resource->state,
                'country' => CountryResource::make($this->whenLoaded('country')),
                'timeZone'=> TimeZoneResource::make($this->whenLoaded('timeZone')),
                'branch_email'=> $this->resource->branch_email,
                'branch_phone'=> $this->resource->branch_phone,
                'branch_website'=> $this->resource->branch_website,
                'is_active'=> $this->resource->is_active,
                'user' => UserResource::make($this->whenLoaded('user')),
                'created_at' => $this->resource->created_at,
            ])
        ];
    }
}
