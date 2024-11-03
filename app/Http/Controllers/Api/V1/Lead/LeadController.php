<?php

namespace App\Http\Controllers\Api\V1\Lead;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Lead\WriteLeadRequest;
use App\Http\Resources\Api\V1\LeadResource;
use App\Models\Lead;
use App\Traits\ApiResponse;
use Spatie\QueryBuilder\QueryBuilder;

class LeadController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $leads = QueryBuilder::for(Lead::class)->with(['leadSource', 'counsellors', 'followups'])->get();
        return LeadResource::collection($leads);
    }

    public function show(Lead $lead)
    {
        $lead->load(['leadSource', 'counsellors', 'followups']);
        return LeadResource::make($lead);
    }

    public function store(WriteLeadRequest $request)
    {

        $lead = Lead::query()->create($request->storeData());
        $lead->counsellors()->sync($request->counsellorId);

        if ($request->leadType) {
            $lead->followups()->create([
                'lead_type' => $request->leadType,
                'follow_up_date' => $request->followUpDate,
                'follow_up_mode' => $request->followUpMode,
                'time' => json_encode($request->time),
                'remarks' => $request->remarks,
                'added_by' => auth()->id()
            ]);
        }
        return $this->ok('Lead created successfully.');
    }

    public function update(Lead $lead, WriteLeadRequest $request)
    {
        $lead->update($request->updateData());
        if ($request->counsellorId) {
            $lead->counsellors()->sync($request->counsellorId);
        }
        if ($request->leadType) {
            $lead->followups()->create([
                'lead_type' => $request->leadType,
                'follow_up_date' => $request->followUpDate,
                'follow_up_mode' => $request->followUpMode,
                'time' => json_encode($request->time),
                'remarks' => $request->remarks,
                'added_by' => auth()->id()
            ]);
        }
        return $this->ok('Lead updated successfully.');
    }
}
