<?php

namespace App\Http\Controllers\Api\V1\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\FrontOffice\StoreFrontOfficeRequest;
use App\Http\Requests\Api\V1\FrontOffice\UpdateFrontOfficeRequest;
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


    public function store(StoreFrontOfficeRequest $request)
    {
        FrontOffice::query()->create($request->storeData());
        return $this->ok('Front Office created successfully.', code: 201);


    }

    public function show(FrontOffice $frontOffice)
    {
        $frontOffice->load(['branch', 'user']);
        return FrontOfficeResource::make($frontOffice);
    }


    public function update(UpdateFrontOfficeRequest $request, FrontOffice $frontOffice)
    {
        $frontOffice->update($request->updateData());
        return $this->ok('Front Office updated successfully.', code: 201);
    }

    public function status(FrontOffice $frontOffice, Request $request)
    {
        $frontOffice->update([
            'is_active' => $request->isActive
        ]);
        return $this->ok('Status updated successfully.', code: 201);
    }
}
