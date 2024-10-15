<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            $this->mergeWhen($request->routeIs('users'), [
                'email' => $this->resource->email,
                'designation' => $this->resource->designation,
                'mobile' => $this->resource->mobile,
                'phone' => $this->resource->phone,
                'skype' => $this->resource->skype,
                'whatsapp' => $this->resource->whatsapp,
                'downloadCsv' => $this->resource->download_csv,
                'createdAt' => $this->resource->created_at,
                'updatedAt' => $this->resource->updated_at,
                'roles' => $this->resource->getRoleNames(),
                'lastLogin' => $this->resource->last_login,
            ])
        ];
    }
}
