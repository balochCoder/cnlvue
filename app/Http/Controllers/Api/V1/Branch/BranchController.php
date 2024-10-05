<?php

namespace App\Http\Controllers\Api\V1\Branch;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreBranchRequest;
use App\Http\Requests\Api\V1\UpdateBranchRequest;
use App\Http\Resources\Api\V1\BranchResource;
use App\Models\Branch;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $branches = Branch::query()
            ->with(['country', 'timeZone', 'user'])
            ->get();
        return BranchResource::collection($branches);
    }


    public function store(StoreBranchRequest $request)
    {
        Branch::query()->create($request->getData());
        return $this->ok('Branch created successfully.', code: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        $branch->load(['country', 'timeZone', 'user']);
        return BranchResource::make($branch);
    }

    public function update(UpdateBranchRequest $request, Branch $branch)
    {
        $branch->update($request->getData());
        return $this->ok('Branch updated successfully.', code: 201);
    }


    public function status(Branch $branch, Request $request)
    {
        $branch->update([
            'is_active' => $request->is_active
        ]);
        return $this->ok('Status updated successfully.');
    }
}
