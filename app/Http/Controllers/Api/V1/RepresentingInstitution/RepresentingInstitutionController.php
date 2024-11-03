<?php

namespace App\Http\Controllers\Api\V1\RepresentingInstitution;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Requests\Api\V1\RepresentingInstitution\StoreRepresentingInstitutionRequest;
use App\Http\Requests\Api\V1\RepresentingInstitution\UpdateRepresentingInstituionRequest;
use App\Http\Resources\Api\V1\RepresentingInstitutionResource;
use App\Models\RepresentingInstitution;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class RepresentingInstitutionController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    use ApiResponse;
    public function index()
    {
        $institutions = QueryBuilder::for(RepresentingInstitution::class)
            ->with(['representingCountry','currency'])
            ->getEloquentBuilder()
            ->get();
        return RepresentingInstitutionResource::collection($institutions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRepresentingInstitutionRequest $request)
    {
        RepresentingInstitution::query()->create($request->getData());
        return $this->ok('Representing Institution created.', code: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(RepresentingInstitution $representingInstitution)
    {

        $representingInstitution
            ->load(['representingCountry','currency']);
        if ($this->include('courses'))
        {
            $representingInstitution->load('courses');
        }
        return RepresentingInstitutionResource::make($representingInstitution);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RepresentingInstitution $representingInstitution, UpdateRepresentingInstituionRequest $request)
    {
        $representingInstitution
            ->update($request->getData());
        return $this->ok('Representing Institution updated.');


    }


    public function status(RepresentingInstitution $representingInstitution, Request $request)
    {
        $representingInstitution->update([
            'is_active' => $request->isActive
        ]);
       return $this->ok('Status updated');
    }
}
