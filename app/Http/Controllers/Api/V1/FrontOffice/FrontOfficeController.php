<?php

namespace App\Http\Controllers\Api\V1\FrontOffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\FrontOffice\StoreFrontOfficeRequest;
use App\Http\Requests\Api\V1\FrontOffice\UpdateFrontOfficeRequest;
use App\Http\Resources\Api\V1\FrontOfficeResource;
use App\Jobs\FrontOffices\CreateFrontOffice;
use App\Jobs\FrontOffices\UpdateFrontOffice;
use App\Models\FrontOffice;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FrontOfficeController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly Dispatcher $bus
    )
    {
    }

    public function index()
    {
        $frontOffices = QueryBuilder::for(FrontOffice::class)
            ->with(['branch', 'user'])
            ->allowedFilters([
                AllowedFilter::exact('branch', 'branch_id'),
                AllowedFilter::exact('email', 'user.email'),
                AllowedFilter::exact('status', 'is_active'),
            ])
            ->getEloquentBuilder()
            ->get();

        return FrontOfficeResource::collection($frontOffices);
    }


    public function store(StoreFrontOfficeRequest $request)
    {
        $this->bus->dispatch(
            command: new CreateFrontOffice($request->storeData())
        );
        return $this->ok('Front Office created successfully.', code: 201);


    }

    public function show(FrontOffice $frontOffice)
    {
        $frontOffice = QueryBuilder::for(FrontOffice::class)
            ->where('id', $frontOffice->id)
            ->with(['branch', 'user'])
            ->firstOrFail();

        return FrontOfficeResource::make($frontOffice);
    }


    public function update(UpdateFrontOfficeRequest $request, FrontOffice $frontOffice)
    {
        $this->bus->dispatch(
            command: new UpdateFrontOffice($request->updateData(), $frontOffice)
        );
        return $this->ok('Front Office updated successfully.', code: 201);
    }

    public function status(FrontOffice $frontOffice, Request $request)
    {
        $frontOffice->update([
            'is_active' => $request->isActive
        ]);
        return $this->ok('Status updated successfully.', code: 201);
    }
}
