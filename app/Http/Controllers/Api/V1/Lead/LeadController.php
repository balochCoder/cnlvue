<?php

namespace App\Http\Controllers\Api\V1\Lead;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Lead\WriteLeadRequest;
use App\Http\Resources\Api\V1\LeadResource;
use App\Jobs\Leads\CreateLead;
use App\Models\Lead;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class LeadController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly Dispatcher $bus
    )
    {
    }

    public function index()
    {
        $leads = QueryBuilder::for(Lead::class)
            ->with(['leadSource', 'counsellors', 'followups', 'branch','interestedInstitution','interestedCountry'])
            ->allowedFilters([
                AllowedFilter::exact('branch', 'branch.id'),
            ])
            ->getEloquentBuilder()
            ->get();
        return LeadResource::collection($leads);
    }

    public function show(Lead $lead)
    {
        $lead = QueryBuilder::for(Lead::class)
            ->where('id', $lead->id)
            ->with(['leadSource', 'counsellors', 'followups', 'interestedCountry', 'interestedInstitution'])
            ->firstOrFail();
        return LeadResource::make($lead);
    }

    public function store(WriteLeadRequest $request)
    {
        $attributes = [
            'storeData' => $request->storeData(),
            'counsellorId' => $request->counsellorId,
            'leadType' => $request->leadType,
            'followUpDate' => $request->followUpDate,
            'followUpMode' => $request->followUpMode,
            'time' => $request->time,
            'remarks' => $request->remarks,
            'addedBy' => auth()->id()
        ];

        $this->bus->dispatch
        (
            command: new CreateLead($attributes)
        );
        return $this->ok('Lead created successfully.');
    }

    public function update(Lead $lead, WriteLeadRequest $request)
    {
        DB::beginTransaction();

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
        DB::commit();
        return $this->ok('Lead updated successfully.');
    }
}
