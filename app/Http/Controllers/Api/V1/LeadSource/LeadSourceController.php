<?php

namespace App\Http\Controllers\Api\V1\LeadSource;

use App\Http\Controllers\Controller;
use App\Http\Filters\IncludeAssociateFilter;
use App\Http\Requests\Api\V1\LeadSource\WriteLeadSourceRequest;
use App\Http\Resources\Api\V1\LeadSourceResource;
use App\Jobs\LeadSources\CreateLeadSource;
use App\Jobs\LeadSources\UpdateLeadSource;
use App\Models\LeadSource;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
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
            ->allowedFilters([
                AllowedFilter::custom('includeAssociate', new IncludeAssociateFilter())
            ])
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
        if ($leadSource->source_name === 'associate') {
            throw new ModelNotFoundException();
        }
        return LeadSourceResource::make($leadSource);
    }

    public function update(LeadSource $leadSource, WriteLeadSourceRequest $request)
    {
        if ($leadSource->source_name === 'associate') {
            throw new ModelNotFoundException();
        }
        $this->bus->dispatch(
            command: new UpdateLeadSource($request->updateData(), $leadSource)
        );
        return $this->ok('Lead source updated.', code: 201);
    }

    public function status(LeadSource $leadSource, Request $request)
    {
        if ($leadSource->source_name === 'associate') {
            throw new ModelNotFoundException();
        }
        $leadSource->update([
            'is_active' => $request->isActive
        ]);
        return $this->ok('Status updated');
    }
}
