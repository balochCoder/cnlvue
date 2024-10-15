<?php

namespace App\Http\Controllers\Api\V1\Remark;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Remark\WriteRemarkRequest;
use App\Http\Resources\Api\V1\RemarkResource;
use App\Models\Remark;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class RemarkController extends Controller
{
    use ApiResponse;
    public function show(Remark $remark)
    {
        $remark->load('counsellor');
        return RemarkResource::make($remark);
    }

    public function store(WriteRemarkRequest $request)
    {
       Remark::query()->create($request->storeData());
       return $this->ok('Remark added successfully');
    }

    public function update(WriteRemarkRequest $request, Remark $remark)
    {
        $remark->update($request->mappedAttributes());
        return $this->ok('Remark updated successfully');
    }
}
