<?php

namespace App\Http\Controllers\Api\V1\LeadSource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LeadSource\WriteLeadSourceRequest;
use App\Http\Resources\Api\V1\LeadSourceResource;
use App\Jobs\LeadSources\CreateLeadSource;
use App\Jobs\LeadSources\UpdateLeadSource;
use App\Models\LeadSource;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class LeadSourceController extends Controller
{
    use ApiResponse;
    public function __construct(
        private readonly Dispatcher $bus
    )
    {
    }

    public function index()
    {
        $leadSources = QueryBuilder::for(LeadSource::class)
            ->with(['user'])
            ->getEloquentBuilder()
            ->get();
        return LeadSourceResource::collection($leadSources);
    }

    public function store(WriteLeadSourceRequest $request)
    {
        $this->bus->dispatch(
            command: new CreateLeadSource($request->storeData())
        );
        return $this->ok('Lead source created.', code: 201);
    }

    public function show(LeadSource $leadSource)
    {
        return LeadSourceResource::make($leadSource);
    }

    public function update(LeadSource $leadSource, WriteLeadSourceRequest $request)
    {
        $this->bus->dispatch(
            command: new UpdateLeadSource($request->updateData(), $leadSource)
        );
        return $this->ok('Lead source updated.', code: 201);
    }

    public function status(LeadSource $leadSource, Request $request)
    {
        $leadSource->update([
            'is_active' => $request->isActive
        ]);
        return $this->ok('Status updated');
    }
}
