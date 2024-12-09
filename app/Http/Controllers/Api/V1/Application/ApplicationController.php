<?php

namespace App\Http\Controllers\Api\V1\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Application\StoreApplicationRequest;
use App\Jobs\Applications\CreateApplication;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function __construct(
        private readonly Dispatcher $bus
    )
    {
    }
    public function store(StoreApplicationRequest $request)
    {
            $this->bus->dispatch(
                command: new CreateApplication($request->getData())
            );
    }
}
