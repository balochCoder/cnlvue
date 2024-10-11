<?php

namespace App\Http\Controllers\Api\V1\SubStatus;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ApplicationProcessResource;
use App\Http\Resources\Api\V1\SubStatusResource;
use App\Models\ApplicationProcess;
use App\Models\SubStatus;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SubStatusController extends ApiController
{
    use ApiResponse;
    public function update(Request $request, SubStatus $subStatus)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $subStatus->update([
            'name' => $request->title,
        ]);

        return SubStatusResource::make($subStatus);
    }

    public function store(Request $request, ApplicationProcess $applicationProcess)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $subStatus = $applicationProcess->subStatuses()->create([
            'name' => $request->title,
            'is_active' => true,
        ]);
        return SubStatusResource::make($subStatus);
    }

    public function status(SubStatus $subStatus, Request $request)
    {
        $subStatus->update([
            'is_active' => $request->isActive
        ]);
        return $this->ok('Status is changed');
    }
}
