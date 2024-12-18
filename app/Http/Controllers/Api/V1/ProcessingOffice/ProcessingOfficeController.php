<?php

namespace App\Http\Controllers\Api\V1\ProcessingOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ProcessingOffice\StoreProcessingOfficeRequest;
use App\Http\Requests\Api\V1\ProcessingOffice\UpdateProcessingOfficeRequest;
use App\Http\Resources\Api\V1\ProcessingOfficeResource;
use App\Http\Resources\Api\V1\RepresentingInstitutionResource;
use App\Jobs\ProcessingOffices\CreateProcessingOffice;
use App\Jobs\ProcessingOffices\UpdateProcessingOffice;
use App\Models\ProcessingOffice;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProcessingOfficeController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly Dispatcher $bus
    )
    {
    }

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
        $this->bus->dispatch(
            command: new CreateProcessingOffice($request->storeData())
        );
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
        $this->bus->dispatch(
            command: new UpdateProcessingOffice($request->updateData(), $processingOffice)
        );
        return $this->ok('Processing Office updated successfully.', code: 201);
    }


    public function status(ProcessingOffice $processingOffice, Request $request)
    {
        $processingOffice->update([
            'is_active' => $request->isActive
        ]);
        $user = User::findOrFail($processingOffice->user_id);
        $user->update([
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
