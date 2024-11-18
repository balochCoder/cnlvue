<?php

namespace App\Http\Controllers\Api\V1\Branch;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Branch\StoreBranchRequest;
use App\Http\Requests\Api\V1\Branch\UpdateBranchRequest;
use App\Http\Resources\Api\V1\BranchResource;
use App\Jobs\Branches\CreateBranch;
use App\Jobs\Branches\UpdateBranch;
use App\Models\Branch;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BranchController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly Dispatcher $bus
    )
    {
    }

    public function index()
    {
        $branches = QueryBuilder::for(Branch::class)
            ->with(['country', 'timeZone', 'user'])
            ->allowedFilters([
                AllowedFilter::exact('email', 'user.email'),
                AllowedFilter::exact('status', 'is_active'),
                AllowedFilter::exact('country', 'country_id'),
            ])
            ->get();
        return BranchResource::collection($branches);
    }


    public function store(StoreBranchRequest $request)
    {
        $this->bus->dispatch(
            command: new CreateBranch($request->storeData())
        );
        return $this->ok('Branch created successfully.', code: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        $branch = QueryBuilder::for(Branch::class)
            ->where('id', $branch->id)
            ->with(['country', 'timeZone', 'user'])
            ->firstOrFail();

        return BranchResource::make($branch);
    }

    public function update(UpdateBranchRequest $request, Branch $branch)
    {
        $this->bus->dispatch(
            command: new UpdateBranch($request->updateData(), $branch)
        );
        return $this->ok('Branch updated successfully.', code: 201);
    }


    public function status(Branch $branch, Request $request)
    {
        $branch->update([
            'is_active' => $request->isActive
        ]);
        return $this->ok('Status updated successfully.');
    }
}
