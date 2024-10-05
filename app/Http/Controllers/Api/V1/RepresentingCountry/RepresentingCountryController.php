<?php

namespace App\Http\Controllers\Api\V1\RepresentingCountry;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\RepresentingCountryRequest;
use App\Http\Resources\Api\V1\RepresentingCountryResource;
use App\Models\RepresentingCountry;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class RepresentingCountryController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $representingCountries = RepresentingCountry::with(['applicationProcesses', 'country', 'representingInstitutions'])
            ->get();

        return RepresentingCountryResource::collection($representingCountries);
    }

    public function store(RepresentingCountryRequest $request)
    {
        $filteredCollection = collect($request->applicationProcess)
            ->filter(function ($item) {
                return !is_null($item['name']);
            });
        $representingCountry = RepresentingCountry::create($request->getData());
        $representingCountry
            ->applicationProcesses()
            ->createMany($filteredCollection->toArray());

        $representingCountry->load('country');
        $representingCountry->load('applicationProcesses');
        return RepresentingCountryResource::make($representingCountry);
    }

    public function status(RepresentingCountry $representingCountry, Request $request)
    {
        $representingCountry->update([
            'is_active' => $request->is_active
        ]);
        return RepresentingCountryResource::make($representingCountry);
    }
}
