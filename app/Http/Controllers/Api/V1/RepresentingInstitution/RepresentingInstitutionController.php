<?php

namespace App\Http\Controllers\Api\V1\RepresentingInstitution;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\RepresentingInstitutionRequest;
use App\Http\Requests\Api\V1\UpdateRepresentingInstitutionRequest;
use App\Http\Resources\Api\V1\RepresentingInstitutionResource;
use App\Models\RepresentingInstitution;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class RepresentingInstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ApiResponse;
    public function index()
    {
        $institutions = RepresentingInstitution::with(['representingCountry','currency'])->get();
        return RepresentingInstitutionResource::collection($institutions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RepresentingInstitutionRequest $request)
    {
        RepresentingInstitution::query()->create($request->getData());
        return $this->ok('Representing Institution created.', code: 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(RepresentingInstitution $representingInstitution)
    {
        $representingInstitution->load(['representingCountry','currency']);
        return RepresentingInstitutionResource::make($representingInstitution);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RepresentingInstitution $representingInstitution, UpdateRepresentingInstitutionRequest $request)
    {
        $representingInstitution->update($request->getData());
        return $this->ok('Representing Institution updated.');


    }


    public function status(RepresentingInstitution $representingInstitution, Request $request)
    {
        $representingInstitution->update([
            'is_active' => $request->is_active
        ]);
       return $this->ok('Status updated');
    }
}
