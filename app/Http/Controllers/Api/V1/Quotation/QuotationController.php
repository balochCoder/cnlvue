<?php

namespace App\Http\Controllers\Api\V1\Quotation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Quotation\StoreQuotationRequest;
use App\Http\Requests\Api\V1\Quotation\UpdateQuotationRequest;
use App\Http\Resources\Api\V1\QuotationResource;
use App\Models\Quotation;
use App\Models\QuotationChoice;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class QuotationController extends Controller
{
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
        DB::beginTransaction();

        $quotation = Quotation::query()->create($request->storeData());

        if ($request->choices) {
            foreach ($request->choices as $choice) {
                QuotationChoice::query()->create([
                    'quotation_id' => $quotation->id,
                    'country_id' => $choice['countryId'],
                    'institution_id' => $choice['institutionId'],
                    'course_id' => $choice['courseId'],
                ]);
            }
        }
        DB::commit();
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
        DB::beginTransaction();
        $quotation->update($request->storeData());

        if ($request->choices) {
            $quotation->quotationChoices()->delete();
            foreach ($request->choices as $choice) {
                QuotationChoice::query()->create([
                    'quotation_id' => $quotation->id,
                    'country_id' => $choice['countryId'],
                    'institution_id' => $choice['institutionId'],
                    'course_id' => $choice['courseId'],
                ]);
            }
        }

        DB::commit();
        return $this->ok('Quotation updated successfully.');
    }
}
