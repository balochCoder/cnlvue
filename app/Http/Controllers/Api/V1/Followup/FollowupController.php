<?php

namespace App\Http\Controllers\Api\V1\Followup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Followup\WriteFollowupRequest;
use App\Models\Followup;
use App\Models\Lead;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

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
}
