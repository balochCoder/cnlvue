<?php

namespace App\Http\Controllers\Api\V1\Lead;

use App\Http\Controllers\Controller;
use App\Http\Filters\ByLastFollowUpDateFilter;
use App\Http\Filters\LeadAddedDateFilter;
use App\Http\Filters\LeadUpdatedDateFilter;
use App\Http\Filters\UnassignedLeadsFilter;
use App\Http\Filters\UniqueLeadsByEmailFilter;
use App\Http\Requests\Api\V1\Lead\WriteLeadRequest;
use App\Http\Resources\Api\V1\LeadResource;
use App\Jobs\Leads\CreateLead;
use App\Jobs\Leads\UpdateLead;
use App\Models\Lead;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Bus\Dispatcher;
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
            ->addSelect([
                'is_duplicated' => function ($query) {
                    $query->selectRaw('CASE
                    WHEN (SELECT COUNT(*)
                          FROM leads AS duplicates
                          WHERE duplicates.student_email = leads.student_email
                          AND duplicates.branch_id = leads.branch_id) > 1
                         AND leads.id = (SELECT MAX(duplicates.id)
                                         FROM leads AS duplicates
                                         WHERE duplicates.student_email = leads.student_email
                                         AND duplicates.branch_id = leads.branch_id)
                    THEN true
                    ELSE false
                END');
                },
            ])
//            ->addSelect([
//                'is_duplicated' => function ($query) {
//                    $query->selectRaw('CASE
//                    WHEN (SELECT COUNT(*) FROM leads AS duplicates WHERE duplicates.student_email = leads.student_email) > 1
//                         AND leads.id = (SELECT MAX(duplicates.id) FROM leads AS duplicates WHERE duplicates.student_email = leads.student_email)
//                    THEN true
//                    ELSE false
//                END');
//                },
//            ])
            ->with(['leadSource', 'counsellors','counsellors.user', 'followups', 'branch','interestedInstitution','interestedCountry','quotation'])

            ->allowedFilters([
                AllowedFilter::exact('country', 'interestedCountry.name'),
                AllowedFilter::exact('branch', 'branch.id'),
                AllowedFilter::exact('counsellor', 'counsellors.id'),
                AllowedFilter::exact('source', 'leadSource.source_name'),
                AllowedFilter::exact('type', 'status'),
                AllowedFilter::custom('followupDate', new ByLastFollowUpDateFilter()),
                AllowedFilter::custom('addedDate', new LeadAddedDateFilter()),
                AllowedFilter::custom('updatedDate', new LeadUpdatedDateFilter()),
                AllowedFilter::exact('generatedApplications','is_application_generated'),
                AllowedFilter::exact('unGeneratedApplications','is_application_generated'),
                AllowedFilter::custom('uniqueLeads',new UniqueLeadsByEmailFilter()),
                AllowedFilter::custom('unAssignedLeads',new UnassignedLeadsFilter()),
            ])
            ->getEloquentBuilder()
            ->latest('id')
            ->get();
        return LeadResource::collection($leads);
    }

    public function show(Lead $lead)
    {
        $lead = QueryBuilder::for(Lead::class)
            ->where('id', $lead->id)
            ->with([
                'branch',
                'leadSource',
                'counsellors.user',
                'followups',
                'interestedCountry',
                'interestedCountry.representingCountry',
                'interestedInstitution',
                'associate',
            ])
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
        $attributes = [
            'updateData' => $request->updateData(),
            'counsellorId' => $request->counsellorId,
            'leadType' => $request->leadType,
            'followUpDate' => $request->followUpDate,
            'followUpMode' => $request->followUpMode,
            'time' => $request->time,
            'remarks' => $request->remarks,
            'addedBy' => auth()->id()
        ];
        $this->bus->dispatch(
            command: new UpdateLead($attributes, $lead)
        );
        return $this->ok('Lead updated successfully.');
    }
}
