<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssociateResource extends JsonResource
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
            'associateName'=> $this->resource->associate_name,
            'branch' => BranchResource::make(
                $this->whenLoaded('branch')
            ),
            $this->mergeWhen($request->routeIs('associates.*'),[
                'address'=> $this->resource->address,
                'city'=> $this->resource->city,
                'state'=> $this->resource->state,
                'phone'=> $this->resource->phone,
                'country' => CountryResource::make($this->whenLoaded('country')),
                'contractTerm'=> $this->resource->contract_term,
                'termsOfAssociation'=> $this->resource->terms_of_association,
                'category'=> $this->resource->category,
                'isActive'=> $this->resource->is_active,
                'user' => UserResource::make($this->whenLoaded('user')),
                'createdAt' => $this->resource->created_at,
            ])
        ];
    }
}
