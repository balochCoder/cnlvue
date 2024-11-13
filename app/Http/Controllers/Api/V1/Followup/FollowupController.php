<?php

namespace App\Http\Controllers\Api\V1\Followup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Followup\WriteFollowupRequest;
use App\Http\Resources\Api\V1\FollowupResource;
use App\Models\Followup;
use App\Models\Lead;
use App\Traits\ApiResponse;
use DB;
use Spatie\QueryBuilder\QueryBuilder;

class FollowupController extends Controller
{
    use ApiResponse;

    public function store(WriteFollowupRequest $request)
    {
        DB::beginTransaction();
        $lead = Lead::query()->findOrFail($request->leadId);
        $lead->followups()->create($request->storeData());

        $lead->update([
            'status' => $request->leadType
        ]);

        DB::commit();

        return $this->ok("Followup successfully added");
    }

    public function index()
    {
        $followups = QueryBuilder::for(
            Followup::class
        )
            ->with(['lead'])
            ->getEloquentBuilder()
            ->get();
        return FollowupResource::collection($followups);
    }
}
