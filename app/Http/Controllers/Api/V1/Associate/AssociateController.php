<?php

namespace App\Http\Controllers\Api\V1\Associate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Associate\StoreAssociateRequest;
use App\Http\Requests\Api\V1\Associate\UpdateAssociateRequest;
use App\Http\Resources\Api\V1\AssociateResource;
use App\Models\Associate;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AssociateController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $associates = QueryBuilder::for(Associate::class)
            ->with(['country', 'branch', 'user'])
            ->allowedFilters([
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
        Associate::query()->create($request->storeData());
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
        $associate->update($request->updateData());
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
