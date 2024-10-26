<?php

namespace App\Http\Controllers\Api\V1\RepresentingCountry;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Requests\Api\V1\RepresentingCountry\StoreRepresentingCountryRequest;
use App\Http\Resources\Api\V1\RepresentingCountryResource;
use App\Models\RepresentingCountry;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class RepresentingCountryController extends ApiController
{
    use ApiResponse;

    public function index()
    {

        if ($this->include('representingInstitutions')) {
            $representingCountries = RepresentingCountry::with(['applicationProcesses', 'country','representingInstitutions'])->get();
        } else {
            $representingCountries = RepresentingCountry::with(['applicationProcesses', 'country'])->get();

        }
        return RepresentingCountryResource::collection($representingCountries);
    }

    public function store(StoreRepresentingCountryRequest $request)
    {
        $filteredCollection = collect($request->applicationProcesses)
            ->filter(function ($item) {
                return !is_null($item['name']);
            });
        $representingCountry = RepresentingCountry::create($request->mappedAttributes());
        $representingCountry
            ->applicationProcesses()
            ->createMany($filteredCollection->toArray());

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
        if ($this->include('applicationProcesses')) {
            $representingCountry->load('applicationProcesses');
        }
        if ($this->include('country')) {
            $representingCountry->load('country');
        }
        return RepresentingCountryResource::make($representingCountry);
    }
}
