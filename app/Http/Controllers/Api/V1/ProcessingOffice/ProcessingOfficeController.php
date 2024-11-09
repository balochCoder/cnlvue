<?php

namespace App\Http\Controllers\Api\V1\ProcessingOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ProcessingOffice\StoreProcessingOfficeRequest;
use App\Http\Requests\Api\V1\ProcessingOffice\UpdateProcessingOfficeRequest;
use App\Http\Resources\Api\V1\ProcessingOfficeResource;
use App\Http\Resources\Api\V1\RepresentingInstitutionResource;
use App\Models\ProcessingOffice;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProcessingOfficeController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $processingOffice = QueryBuilder::for(ProcessingOffice::class)
            ->with(['country', 'timeZone', 'user'])
            ->allowedFilters([
                AllowedFilter::partial('email', 'user.email'),
                AllowedFilter::partial('user', 'user.name'),
                AllowedFilter::exact('country', 'country_id'),
            ])
            ->getEloquentBuilder()
            ->get();
        return ProcessingOfficeResource::collection($processingOffice);
    }


    public function store(StoreProcessingOfficeRequest $request)
    {
        ProcessingOffice::query()->create($request->storeData());
        return $this->ok('Processing Office created successfully.', code: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProcessingOffice $processingOffice)
    {
        $processingOffice = QueryBuilder::for(ProcessingOffice::class)
            ->where('id', $processingOffice->id)
            ->with(['country', 'timeZone', 'user'])
            ->firstOrFail();

        return ProcessingOfficeResource::make($processingOffice);
    }

    public function update(UpdateProcessingOfficeRequest $request, ProcessingOffice $processingOffice)
    {
        $processingOffice->update($request->updateData());
        return $this->ok('Processing Office updated successfully.', code: 201);
    }


    public function status(ProcessingOffice $processingOffice, Request $request)
    {
        $processingOffice->update([
            'is_active' => $request->isActive
        ]);
        return $this->ok('Status updated successfully.');
    }

    public function assign(ProcessingOffice $processingOffice, Request $request)
    {
        $request->validate([
            'institutions' => ['nullable', 'array'],
        ]);
        $processingOffice->institutions()->sync($request->institutions);
        return $this->ok('Processing Office assigned successfully.');
    }

    public function getAssignedInstitutions(ProcessingOffice $processingOffice)
    {
        return RepresentingInstitutionResource::collection($processingOffice->institutions()->get());
    }
}
