<?php

namespace App\Http\Controllers\Api\V1\Country;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\Api\V1\CountryResource;
use App\Models\Country;
use App\Traits\ApiResponse;
use Spatie\QueryBuilder\QueryBuilder;

class CountryController extends ApiController
{
    use ApiResponse;

    public function __invoke()
    {
        $countries = QueryBuilder::for(Country::class)
            ->getEloquentBuilder()
            ->get();
        return CountryResource::collection($countries);
    }
}
