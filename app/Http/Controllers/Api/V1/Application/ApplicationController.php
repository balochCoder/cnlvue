<?php

namespace App\Http\Controllers\Api\V1\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Application\StoreApplicationRequest;
use App\Http\Resources\Api\V1\ApplicationResource;
use App\Jobs\Applications\CreateApplication;
use App\Models\Application;
use Illuminate\Contracts\Bus\Dispatcher;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ApplicationController extends Controller
{
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
            ])
            ->allowedFilters([
                AllowedFilter::exact('counsellor', 'counsellor_id'),
            ])
            ->getEloquentBuilder()
            ->get();

        return ApplicationResource::collection($applications);
    }

    public function store(StoreApplicationRequest $request)
    {
        $this->bus->dispatch(
            command: new CreateApplication($request->getData())
        );
    }
}
