<?php

namespace App\Http\Controllers\Api\V1\ApplicationStatus;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ApplicationStatus\WriteApplicationStatusRequest;
use App\Jobs\ApplicationStatuses\CreateApplicationStatus;
use Illuminate\Contracts\Bus\Dispatcher;

class ApplicationStatusController extends Controller
{
    public function __construct(
        private readonly Dispatcher $bus
    )
    {
    }

    public function __invoke(WriteApplicationStatusRequest $request)
    {
        $this->bus->dispatch(
            command: new CreateApplicationStatus($request->storeData())
        );
    }
}
