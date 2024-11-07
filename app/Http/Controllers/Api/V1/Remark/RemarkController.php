<?php

namespace App\Http\Controllers\Api\V1\Remark;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Remark\WriteRemarkRequest;
use App\Http\Resources\Api\V1\RemarkResource;
use App\Models\Remark;
use App\Traits\ApiResponse;
use Spatie\QueryBuilder\QueryBuilder;

class RemarkController extends Controller
{
    use ApiResponse;
    public function show(Remark $remark)
    {
        $remark = QueryBuilder::for(Remark::class)
            ->where('id', $remark->id)
            ->with(['counsellor'])
            ->firstOrFail();
        return RemarkResource::make($remark);
    }

    public function store(WriteRemarkRequest $request)
    {
       $remark = Remark::query()->create($request->storeData());
       return RemarkResource::make($remark);
    }

    public function update(WriteRemarkRequest $request, Remark $remark)
    {
        $remark->update($request->mappedAttributes());
        return RemarkResource::make($remark);
    }
}
