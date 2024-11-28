<?php

namespace App\Http\Controllers\Api\V1\Quotation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Quotation\StoreQuotationRequest;
use App\Http\Requests\Api\V1\Quotation\UpdateQuotationRequest;
use App\Http\Resources\Api\V1\QuotationResource;
use App\Jobs\Quotations\CreateQuotation;
use App\Jobs\Quotations\UpdateQuotation;
use App\Models\Quotation;
use App\Models\QuotationChoice;
use App\Traits\ApiResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class QuotationController extends Controller
{
    public function __construct(
        private readonly Dispatcher $bus
    )
    {
    }

    public function index()
    {
        $quotations = QueryBuilder::for(Quotation::class)
            ->with(['lead'])
            ->getEloquentBuilder()
            ->get();
        return QuotationResource::collection($quotations);
    }

    use ApiResponse;

    public function store(StoreQuotationRequest $request)
    {
        $attributes = [
            'storeData' => $request->getData(),
            'choices' => $request->choices,
        ];

        $this->bus->dispatch(
            command: new CreateQuotation($attributes)
        );

        return $this->ok('Quotation generated successfully.');
    }

    public function show(Quotation $quotation)
    {
        $quotation = QueryBuilder::for(Quotation::class)
            ->where('quotation.id', $quotation->id)
            ->with(['lead'])
            ->firstOrFail();
        return QuotationResource::make($quotation);
    }

    public function update(UpdateQuotationRequest $request, Quotation $quotation)
    {
        $attributes = [
            'storeData' => $request->getData(),
            'choices' => $request->choices,
        ];
        $this->bus->dispatch(
            command: new UpdateQuotation($attributes, $quotation)
        );
        return $this->ok('Quotation updated successfully.');
    }
    public function pdf(Quotation $quotation)
    {
        $pdf = Pdf::loadView('quotation.pdf', compact('quotation'));
        return $pdf->download('quotation.pdf');
    }
}
