<?php

namespace App\Http\Controllers\Api\V1\ProcessingOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreProcessingOfficeRequest;
use App\Http\Requests\Api\V1\UpdateProcessingOfficeRequest;
use App\Http\Resources\Api\V1\ProcessingOfficeResource;
use App\Models\ProcessingOffice;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProcessingOfficeController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $branches = ProcessingOffice::query()
            ->with(['country', 'timeZone', 'user'])
            ->get();
        return ProcessingOfficeResource::collection($branches);
    }


    public function store(StoreProcessingOfficeRequest $request)
    {
        ProcessingOffice::query()->create($request->getData());
        return $this->ok('Processing Office created successfully.', code: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProcessingOffice $processingOffice)
    {
        $processingOffice->load(['country', 'timeZone', 'user']);
        return ProcessingOfficeResource::make($processingOffice);
    }

    public function update(UpdateProcessingOfficeRequest $request, ProcessingOffice $processingOffice)
    {
        $processingOffice->update($request->getData());
        return $this->ok('Processing Office updated successfully.', code: 201);
    }


    public function status(ProcessingOffice $processingOffice, Request $request)
    {
        $processingOffice->update([
            'is_active' => $request->is_active
        ]);
        return $this->ok('Status updated successfully.');
    }
}
