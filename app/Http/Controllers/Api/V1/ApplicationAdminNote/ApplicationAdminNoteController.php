<?php

namespace App\Http\Controllers\Api\V1\ApplicationAdminNote;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ApplicationAdminNote\WriteApplicationAdminNoteRequest;
use App\Models\ApplicationAdminNote;
use App\Traits\ApiResponse;

class ApplicationAdminNoteController extends Controller
{
    use ApiResponse;
    /**
     * Handle the incoming request.
     */
    public function __invoke(WriteApplicationAdminNoteRequest $request)
    {
        ApplicationAdminNote::query()->create(
            $request->storeData()
        );

        return $this->ok('Application admin note created successfully.');
    }
}
