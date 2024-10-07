<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

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
            'id'=>$this->resource->id,
            'name'=>$this->resource->name,
            'email'=>$this->resource->email,
            'designation'=>$this->resource->designation,
            'mobile'=>$this->resource->mobile,
            'phone'=>$this->resource->phone,
            'skype'=>$this->resource->skype,
            'whatsapp'=>$this->resource->whatsapp,
            'download_csv'=>$this->resource->download_csv,
            'createdAt'=>$this->resource->created_at,
            'updatedAt'=>$this->resource->updated_at,
            'role' => $this->resource->getRoleNames(),
            'last_login' => $this->resource->last_login,
        ];
    }
}
