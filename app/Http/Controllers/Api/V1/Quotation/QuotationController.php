<?php

namespace App\Http\Controllers\Api\V1\Quotation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Quotation\StoreQuotationRequest;
use App\Http\Resources\Api\V1\QuotationResource;
use App\Models\Quotation;
use App\Traits\ApiResponse;

class QuotationController extends Controller
{
    public function index()
    {
        $quotations = Quotation::query()->with(['lead'])->get();
        return QuotationResource::collection($quotations);
    }
    use ApiResponse;
    public function store(StoreQuotationRequest $request)
    {
       Quotation::query()->create($request->storeData());
       return $this->ok('Quotation generated successfully.');
    }
    public function show(Quotation $quotation)
    {
        $quotation->load(['lead']);
        return QuotationResource::make($quotation);
    }
}
