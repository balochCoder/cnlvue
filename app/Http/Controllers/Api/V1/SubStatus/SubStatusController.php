<?php

namespace App\Http\Controllers\Api\V1\SubStatus;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ApplicationProcessResource;
use App\Http\Resources\Api\V1\SubStatusResource;
use App\Models\ApplicationProcess;
use App\Models\SubStatus;
use Illuminate\Http\Request;

class SubStatusController extends Controller
{
    public function index(ApplicationProcess $applicationProcess)
    {
        $applicationProcess = $applicationProcess->load('subStatuses');
        return ApplicationProcessResource::make($applicationProcess);

    }
    public function update(Request $request, SubStatus $subStatus)
    {

        $request->validate([
            'name' => 'required',
        ]);

        $subStatus->update([
            'name' => $request->name,
        ]);

        return SubStatusResource::make($subStatus);
    }

    public function store(Request $request, ApplicationProcess $applicationProcess)
    {
        $request->validate([
            'sub_status' => 'required',
        ]);

        $subStatus = $applicationProcess->subStatuses()->create([
            'name' => $request->sub_status,
        ]);
        return SubStatusResource::make($subStatus);
    }

    public function status(SubStatus $subStatus, Request $request)
    {
        $subStatus->update([
            'is_active' => $request->is_active
        ]);
        return SubStatusResource::make($subStatus);
    }
}
