<?php

namespace App\Http\Controllers\Api\V1\RepresentingInstitution;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Filters\ContractExpireAtFilter;
use App\Http\Filters\CoursesFilter;
use App\Http\Filters\CourseTitleFilter;
use App\Http\Requests\Api\V1\RepresentingInstitution\StoreRepresentingInstitutionRequest;
use App\Http\Requests\Api\V1\RepresentingInstitution\UpdateRepresentingInstituionRequest;
use App\Http\Resources\Api\V1\CourseResource;
use App\Http\Resources\Api\V1\RepresentingInstitutionResource;
use App\Models\Course;
use App\Models\RepresentingInstitution;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RepresentingInstitutionController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    use ApiResponse;

    public function index()
    {
        $institutions = QueryBuilder::for(RepresentingInstitution::class)
            ->with(['representingCountry', 'currency'])
            ->allowedFilters([
                AllowedFilter::exact('country', 'representing_country_id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('type'),
                AllowedFilter::partial('email', 'contact_person_email'),
                AllowedFilter::custom('contract_expire_at', new ContractExpireAtFilter())
            ])
            ->getEloquentBuilder()
            ->get();
        return RepresentingInstitutionResource::collection($institutions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRepresentingInstitutionRequest $request)
    {
        RepresentingInstitution::query()->create($request->getData());
        return $this->ok('Representing Institution created.', code: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(RepresentingInstitution $representingInstitution)
    {
        $representingInstitution = QueryBuilder::for(
            RepresentingInstitution::where('id', $representingInstitution->id)
        )
            ->with(['representingCountry', 'currency'])
            ->firstOrFail();

        return RepresentingInstitutionResource::make($representingInstitution);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RepresentingInstitution $representingInstitution, UpdateRepresentingInstituionRequest $request)
    {
        $representingInstitution
            ->update($request->getData());
        return $this->ok('Representing Institution updated.');


    }


    public function status(RepresentingInstitution $representingInstitution, Request $request)
    {
        $representingInstitution->update([
            'is_active' => $request->isActive
        ]);
        return $this->ok('Status updated');
    }

    public function courses(RepresentingInstitution $representingInstitution)
    {
        $courses = QueryBuilder::for(Course::class)
            ->where('representing_institution_id', $representingInstitution->id)
            ->allowedFilters([
                AllowedFilter::exact('level'),
                AllowedFilter::partial('title'),
                AllowedFilter::partial('campus'),
            ])
            ->getEloquentBuilder()
            ->get();

        return CourseResource::collection($courses);
    }

}
