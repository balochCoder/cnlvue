<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Api\DateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
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
                'roles' => $this->resource->getRoleNames(),
                'lastLogin' => $this->resource->last_login,
                'createdAt' => DateResource::make(
                    $this->resource->created_at
                ),
                'updatedAt' => DateResource::make(
                    $this->resource->updated_at
                ),
            ])
        ];
    }
}
