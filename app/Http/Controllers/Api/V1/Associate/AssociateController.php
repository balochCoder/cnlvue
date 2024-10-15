<?php

namespace App\Http\Controllers\Api\V1\Associate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Associate\StoreAssociateRequest;
use App\Http\Requests\Api\V1\Associate\UpdateAssociateRequest;
use App\Http\Requests\Api\V1\Branch\StoreBranchRequest;
use App\Http\Requests\Api\V1\Branch\UpdateBranchRequest;
use App\Http\Resources\Api\V1\AssociateResource;
use App\Http\Resources\Api\V1\BranchResource;
use App\Models\Associate;
use App\Models\Branch;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AssociateController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $associates = Associate::query()
            ->with(['country', 'branch', 'user'])
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
        $associate->load(['country', 'branch', 'user']);
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
