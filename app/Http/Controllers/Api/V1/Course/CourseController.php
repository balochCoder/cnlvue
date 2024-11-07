<?php

namespace App\Http\Controllers\Api\V1\Course;

use App\Http\Controllers\Api\V1\ApiController;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\Api\V1\Course\{StoreCourseRequest, UpdateCourseRequest};
use App\Http\Resources\Api\V1\CourseResource;
use App\Models\{Course};
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CourseController extends ApiController
{
    use ApiResponse;

    public function store(StoreCourseRequest $request)
    {
        $course = Course::query()->create($request->getData());
        return CourseResource::make($course);
    }

    public function show(Course $course)
    {
        $course = QueryBuilder::for(Course::class)
            ->where('id', $course->id)
            ->with(['currency'])
            ->firstOrFail();

        return CourseResource::make($course);
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->getData());
        return CourseResource::make($course);
    }

    public function status(Course $course, Request $request)
    {
        $course->update([
            'is_active' => $request->isActive
        ]);
        return $this->ok('Course status updated successfully');
    }
}
