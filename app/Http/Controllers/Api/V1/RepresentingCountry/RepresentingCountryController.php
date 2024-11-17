<?php

namespace App\Http\Controllers\Api\V1\RepresentingCountry;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Requests\Api\V1\RepresentingCountry\StoreRepresentingCountryRequest;
use App\Http\Resources\Api\V1\RepresentingCountryResource;
use App\Jobs\RepresentingCountries\CreateRepresentingCountry;
use App\Models\RepresentingCountry;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RepresentingCountryController extends ApiController
{
    use ApiResponse;

    public function __construct(
        private readonly Dispatcher $bus
    )
    {
    }

    public function index()
    {
        $representingCountries = QueryBuilder::for(RepresentingCountry::class)
            ->allowedIncludes(['representingInstitutions'])
            ->allowedFilters(['is_active', AllowedFilter::exact('id')])
            ->with(['applicationProcesses', 'country'])
            ->getEloquentBuilder()
            ->get();

        return RepresentingCountryResource::collection($representingCountries);
    }

    public function store(StoreRepresentingCountryRequest $request)
    {
        $this->bus->dispatch(
            command: new CreateRepresentingCountry(
                $request->mappedAttributes(),
                $request->applicationProcesses
            )
        );
        return $this->ok('Representing country successfully created');
    }

    public function status(RepresentingCountry $representingCountry, Request $request)
    {
        $representingCountry->update([
            'is_active' => $request->isActive
        ]);
        return $this->ok('Representing country successfully updated');
    }

    public function show(RepresentingCountry $representingCountry)
    {
        $representingCountry = QueryBuilder::for(RepresentingCountry::class)
            ->where('id', $representingCountry->id)
            ->with(['country'])
            ->allowedIncludes(['applicationProcesses'])
            ->firstOrFail();

        return RepresentingCountryResource::make($representingCountry);
    }
}
