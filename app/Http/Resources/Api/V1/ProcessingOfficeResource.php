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
                'processing_office_phone'=> $this->resource->processing_office_phone,
                'download_csv'=> $this->resource->download_csv,
                'is_active'=> $this->resource->is_active,
                'contact_person_name'=> $this->resource->contact_person_name,
                'contact_person_designation'=> $this->resource->contact_person_designation,
                'contact_person_phone'=> $this->resource->contact_person_phone,
                'contact_person_mobile'=> $this->resource->contact_person_mobile,
                'contact_person_skype'=> $this->resource->contact_person_skype,
                'user' => UserResource::make($this->whenLoaded('user')),
                'created_at' => $this->resource->created_at,
            ])
        ];
    }
}
