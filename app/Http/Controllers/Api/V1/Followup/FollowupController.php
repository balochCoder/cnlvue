<?php

namespace App\Http\Controllers\Api\V1\Followup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Followup\WriteFollowupRequest;
use App\Http\Resources\Api\V1\FollowupResource;
use App\Models\Followup;
use App\Models\Lead;
use App\Traits\ApiResponse;

class FollowupController extends Controller
{
    use ApiResponse;

    public function store(WriteFollowupRequest $request)
    {
        Followup::query()->create($request->storeData());

        $lead = Lead::query()->findOrFail($request->leadId);
        $lead->update([
            'status' => $request->leadType
        ]);

        return $this->ok("Followup successfully added");
    }

    public function index()
    {
        $followups = Followup::query()->with(['lead'])->get();
        return FollowupResource::collection($followups);
    }
}
