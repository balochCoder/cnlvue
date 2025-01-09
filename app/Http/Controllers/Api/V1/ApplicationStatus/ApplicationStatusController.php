<?php

namespace App\Http\Controllers\Api\V1\ApplicationStatus;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ApplicationStatus\WriteApplicationStatusRequest;
use App\Jobs\ApplicationStatuses\CreateApplicationStatus;
use App\Models\ApplicationStatus;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Bus\Dispatcher;

class ApplicationStatusController extends Controller
{
    use ApiResponse;
    public function __construct(
        private readonly Dispatcher $bus
    )
    {
    }

    public function __invoke(WriteApplicationStatusRequest $request)
    {
        ApplicationStatus::query()->create($request->storeData());
//        $this->bus->dispatch(
//            command: new CreateApplicationStatus($request->storeData())
//        );
        return $this->ok('Application Status created successfully');

    }
}
