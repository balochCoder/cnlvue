<?php

namespace App\Http\Controllers\Api\V1\Associate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Associate\StoreAssociateRequest;
use App\Http\Requests\Api\V1\Associate\UpdateAssociateRequest;
use App\Http\Resources\Api\V1\AssociateResource;
use App\Jobs\Associates\CreateAssociate;
use App\Jobs\Associates\UpdateAssociate;
use App\Models\Associate;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AssociateController extends Controller
{
    use ApiResponse;
public function __construct(
    private readonly Dispatcher $bus
)
{
}

    public function index()
    {
        $associates = QueryBuilder::for(Associate::class)
            ->with(['country', 'branch', 'user'])
            ->allowedFilters([
                AllowedFilter::exact('branch','branch_id'),
                AllowedFilter::exact('email', 'user.email'),
                AllowedFilter::exact('status', 'is_active'),
                AllowedFilter::exact('category'),
                AllowedFilter::exact('country', 'country_id'    ),
            ])
            ->getEloquentBuilder()
            ->get();
        return AssociateResource::collection($associates);
    }


    public function store(StoreAssociateRequest $request)
    {
        $this->bus->dispatch(
            command: new CreateAssociate($request->storeData())
        );
        return $this->ok('Associate created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Associate $associate)
    {
        $associate = QueryBuilder::for(Associate::class)
            ->where('id', $associate->id)
            ->with(['country', 'branch', 'user'])
            ->firstOrFail();
        return AssociateResource::make($associate);
    }

    public function update(UpdateAssociateRequest $request, Associate $associate)
    {
        $this->bus->dispatch(
            command: new UpdateAssociate($request->updateData(), $associate)
        );
        return $this->ok('Associate updated successfully');
    }


    public function status(Associate $associate, Request $request)
    {
        $associate->update([
            'is_active' => $request->isActive
        ]);
        return $this->ok('Status updated successfully.');
    }
}
