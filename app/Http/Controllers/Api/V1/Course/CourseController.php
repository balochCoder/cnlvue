<?php

namespace App\Http\Controllers\Api\V1\Course;

use App\Http\Controllers\Api\V1\ApiController;
use App\Jobs\Courses\CreateCourse;
use App\Jobs\Courses\UpdateCourse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Bus\Dispatcher;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\Api\V1\Course\{StoreCourseRequest, UpdateCourseRequest};
use App\Http\Resources\Api\V1\CourseResource;
use App\Models\{Course, Quotation};
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CourseController extends ApiController
{
    use ApiResponse;

    public function __construct(
        private readonly Dispatcher $bus
    )
    {
    }

    public function index()
    {
        $courses = QueryBuilder::for(Course::class)
            ->with(['representingInstitution', 'representingInstitution.representingCountry', 'currency'])
            ->allowedFilters([
                AllowedFilter::exact('country', 'representingInstitution.representingCountry.id'),
                AllowedFilter::exact('institution', 'representing_institution_id'),
                AllowedFilter::partial('category', 'course_category'),
                AllowedFilter::partial('intake'),
                AllowedFilter::exact('level'),
                AllowedFilter::exact('quality', 'quality_of_applicant'),
                AllowedFilter::partial('amount', 'fee'),
            ])
            ->getEloquentBuilder()
            ->get();

        return CourseResource::collection($courses);
    }

    public function store(StoreCourseRequest $request)
    {


        $this->bus->dispatch(
            command: new CreateCourse($request->getData())
        );

        return $this->ok('Course added successfully');

    }

    public function show(Course $course)
    {
        $course = QueryBuilder::for(Course::class)
            ->where('id', $course->id)
            ->with(['currency', 'representingInstitution'])
            ->firstOrFail();

        return CourseResource::make($course);
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $this->bus->dispatch(
            command: new UpdateCourse($request->getData(), $course)
        );
        return $this->ok('Course updated successfully');
    }

    public function status(Course $course, Request $request)
    {
        $course->update([
            'is_active' => $request->isActive
        ]);
        return $this->ok('Course status updated successfully');
    }

    public function pdf(Course $course)
    {
        $pdf = Pdf::loadView('course.pdf', compact('course'));

        return $pdf->download('course.pdf');
    }
}

