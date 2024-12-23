<?php

namespace App\Http\Controllers\Api\V1\Followup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Followup\WriteFollowupRequest;
use App\Http\Resources\Api\V1\FollowupResource;
use App\Models\Application;
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
        if ($request->leadId){
            $lead = Lead::query()->findOrFail($request->leadId);
            $lead->followups()->create($request->storeData());
            $lead->update([
                'status' => $request->leadType
            ]);
        }
        if ($request->applicationId){
            $application = Application::query()->findOrFail($request->applicationId);
            $application->followups()->create($request->storeData());
        }

        DB::commit();

        return $this->ok("Followup successfully added");
    }

    public function index()
    {
        $followups = QueryBuilder::for(Followup::class)
            ->whereHas('followupable', function ($query) {
                $query->where('followupable_type', Lead::class);
            })
            ->getEloquentBuilder()
            ->get();
        return FollowupResource::collection($followups);
    }
}
