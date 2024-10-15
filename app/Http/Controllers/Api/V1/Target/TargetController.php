<?php

namespace App\Http\Controllers\Api\V1\Target;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Target\WriteTargetRequest;
use App\Http\Resources\Api\V1\TargetResource;
use App\Models\Target;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    use ApiResponse;
    public function show(Target $target)
    {
        $target->load('counsellor');
        return TargetResource::make($target);
    }

    public function store(WriteTargetRequest $request)
    {
        Target::query()->create($request->storeData());
        return $this->ok('Target was created');
    }

    public function update(Target $target, WriteTargetRequest $request)
    {
        $target->update($request->mappedAttributes());
        return $this->ok('Target was updated');
    }
}
