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
            'mobile' => $this->resource->mobile,
            'lastLogin' => $this->resource->last_login,
            'email' => $this->resource->email,
            'designation' => $this->resource->designation,
            'phone' => $this->resource->phone,
            'skype' => $this->resource->skype,
            'whatsapp' => $this->resource->whatsapp,
            'downloadCsv' => $this->resource->download_csv,
            'roles' => $this->resource->getRoleNames(),
            $this->mergeWhen($this->resource->hasRole('branch') , [
                'branch' => BranchResource::make($this->resource->branch),
            ]),
            $this->mergeWhen($this->resource->hasRole('counsellor') && $request->routeIs('user'), [
                'counsellor' => CounsellorResource::make($this->resource->counsellor),
            ]),
            $this->mergeWhen($request->routeIs('users'), [
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
