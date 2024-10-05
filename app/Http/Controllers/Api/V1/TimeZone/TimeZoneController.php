<?php

namespace App\Http\Controllers\Api\V1\TimeZone;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CurrencyResource;
use App\Http\Resources\Api\V1\TimeZoneResource;
use App\Models\Currency;
use App\Models\TimeZone;
use Illuminate\Http\Request;

class TimeZoneController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return TimeZoneResource::collection(TimeZone::query()->get());
    }
}
