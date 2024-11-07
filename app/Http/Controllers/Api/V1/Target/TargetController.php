<?php

namespace App\Http\Controllers\Api\V1\Target;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Target\WriteTargetRequest;
use App\Http\Resources\Api\V1\TargetResource;
use App\Models\Target;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class TargetController extends Controller
{
    use ApiResponse;
    public function show(Target $target)
    {
        $target = QueryBuilder::for(Target::class)
            ->where('id', $target->id)
            ->with(['counsellor'])
            ->firstOrFail();

        return TargetResource::make($target);
    }

    public function store(WriteTargetRequest $request)
    {
        $target = Target::query()->create($request->storeData());
        return TargetResource::make($target);
    }

    public function update(Target $target, WriteTargetRequest $request)
    {
        $target->update($request->mappedAttributes());
        return TargetResource::make($target);
    }
}
