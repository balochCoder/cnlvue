<?php

namespace App\Http\Controllers\Api\V1\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Application\StoreApplicationRequest;
use App\Http\Requests\Api\V1\Application\UpdateApplicationRequest;
use App\Http\Resources\Api\V1\ApplicationResource;
use App\Jobs\Applications\CreateApplication;
use App\Jobs\Applications\UpdateApplication;
use App\Models\Application;
use App\Traits\ApiResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Bus\Dispatcher;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ApplicationController extends Controller
{
    use ApiResponse;
    public function __construct(
        private readonly Dispatcher $bus
    )
    {
    }

    public function index()
    {
        $applications = QueryBuilder::for(Application::class)
            ->with([
                'student.lead',
                'counsellor',
                'currency',
                'leadSource',
                'course',
                'course.representingInstitution',
                'course.representingInstitution.representingCountry',
                'applicationStatuses'=> fn($query) => $query->latest('id'),
                'applicationStatuses.applicationProcess',
                'applicationStatuses.subStatus',
                'associate',
                'followups',
                'tasks',
                'tasks.remarks',
                'tasks.assignedTo',
                'tasks.assignedBy',
                'adminNotes'
            ])
            ->allowedFilters([
                AllowedFilter::exact('counsellor', 'counsellor_id'),
            ])
            ->getEloquentBuilder()
            ->latest('id')
            ->get();

        return ApplicationResource::collection($applications);
    }

    public function store(StoreApplicationRequest $request)
    {
        $this->bus->dispatch(
            command: new CreateApplication($request->getData())
        );
        return $this->ok('Application created successfully');
    }

    public function show(Application $application)
    {
        $application = QueryBuilder::for(Application::class)
            ->where('id', $application->id)
            ->with([
                'student.lead',
                'counsellor', 'counsellor.user',
                'currency',
                'leadSource',
                'course',
                'course.representingInstitution',
                'course.representingInstitution.representingCountry',
                'applicationStatuses'=> fn($query) => $query->latest('id'),
                'applicationStatuses.applicationProcess',
                'applicationStatuses.subStatus',
                'associate',
                'adminNotes',
                'followups' => fn($query) => $query->latest('id'),
            ])
            ->allowedFilters([
                AllowedFilter::exact('counsellor', 'counsellor_id'),
            ])
            ->firstOrFail();
        $followupsCountByMode = $application->followups()
            ->selectRaw('follow_up_mode, COUNT(*) as count')
            ->groupBy('follow_up_mode')
            ->pluck('count', 'follow_up_mode')
            ->toArray();

        $application->setRelation('followupsCountByMode', $followupsCountByMode);
        return ApplicationResource::make($application);
    }

    public function pdf(Application $application)
    {
        $pdf = Pdf::loadView('application.pdf', compact('application'));
        return $pdf->download('application.pdf');
    }

    public function report(Application $application)
    {
        $followupsCountByMode = $application->followups()
            ->selectRaw('follow_up_mode, COUNT(*) as count')
            ->groupBy('follow_up_mode')
            ->pluck('count', 'follow_up_mode')
            ->toArray();

        $application->setRelation('followupsCountByMode', $followupsCountByMode);
        $pdf = Pdf::loadView('application.report', compact('application'));
        return $pdf->download('report.pdf');
    }

    public function update(Application $application,UpdateApplicationRequest $request)
    {
        $this->bus->dispatch(
            command: new UpdateApplication($request->getData(), $application)
        );
        return $this->ok('Application updated successfully');
    }
}
