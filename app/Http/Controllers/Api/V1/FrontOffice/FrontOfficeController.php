<?php

namespace App\Http\Controllers\Api\V1\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreFrontOfficeRequest;
use App\Http\Requests\Api\V1\UpdateFrontOfficeRequest;
use App\Http\Resources\Api\V1\FrontOfficeResource;
use App\Models\FrontOffice;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class FrontOfficeController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $frontOffices = FrontOffice::query()
            ->with(['branch', 'user'])
            ->paginate(10);

        return FrontOfficeResource::collection($frontOffices);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFrontOfficeRequest $request)
    {
        FrontOffice::query()->create($request->getData());
        return $this->ok('Front Office created successfully.', code: 201);


    }

    /**
     * Display the specified resource.
     */
    public function show(FrontOffice $frontOffice)
    {
        $frontOffice->load(['branch', 'user']);
        return FrontOfficeResource::make($frontOffice);
    }


    public function update(UpdateFrontOfficeRequest $request, FrontOffice $frontOffice)
    {
        $frontOffice->update($request->getData());
        return $this->ok('Front Office updated successfully.', code: 201);
    }

    public function status(FrontOffice $frontOffice, Request $request)
    {
        $frontOffice->update([
            'is_active' => $request->is_active
        ]);
        return $this->ok('Status updated successfully.', code: 201);
    }
}
