<?php

namespace App\Http\Controllers\Api\V1\Counsellor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Counsellor\StoreCounsellorRequest;
use App\Http\Requests\Api\V1\Counsellor\UpdateCounsellorRequest;
use App\Http\Resources\Api\V1\CounsellorResource;
use App\Http\Resources\Api\V1\RepresentingInstitutionResource;
use App\Models\Counsellor;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CounsellorController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $counsellors = Counsellor::query()
            ->with(['branch', 'user'])
            ->paginate(10);

        return CounsellorResource::collection($counsellors);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCounsellorRequest $request)
    {
        Counsellor::query()->create($request->storeData());
        return $this->ok('Counsellor created successfully.', code: 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Counsellor $counsellor)
    {
        $counsellor->load(['branch', 'user']);
        return CounsellorResource::make($counsellor);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCounsellorRequest $request, Counsellor $counsellor)
    {
        $counsellor->update($request->updateData());
        return $this->ok('Counsellor updated successfully.', code: 201);
    }


    public function status(Counsellor $counsellor, Request $request)
    {
        $counsellor->update([
            'is_active' => $request->isActive
        ]);
        return $this->ok('Status updated successfully.');
    }

    public function assign(Counsellor $counsellor, Request $request)
    {
        $request->validate([
            'institutions' => ['nullable', 'array'],
        ]);
        $counsellor->institutions()->sync($request->institutions);
        return $this->ok('Counsellor assigned successfully.');
    }

    public function getAssignedInstitutions(Counsellor $counsellor)
    {
        return RepresentingInstitutionResource::collection($counsellor->institutions()->get());
    }
}
