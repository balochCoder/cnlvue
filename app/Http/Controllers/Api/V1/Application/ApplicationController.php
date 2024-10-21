<?php

namespace App\Http\Controllers\Api\V1\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Application\StoreApplicationRequest;
use App\Http\Resources\Api\V1\ApplicationResource;
use App\Models\Application;
use App\Traits\ApiResponse;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::query()->with(['lead'])->get();
        return ApplicationResource::collection($applications);
    }
    use ApiResponse;
    public function store(StoreApplicationRequest $request)
    {
       Application::query()->create($request->storeData());
       return $this->ok('Application generated successfully.');
    }
    public function show(Application $application)
    {
        $application->load(['lead']);
        return ApplicationResource::make($application);
    }
}
