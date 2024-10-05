<?php

namespace App\Http\Controllers\Api\V1\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreCourseRequest;
use App\Http\Requests\Api\V1\UpdateCourseRequest;
use App\Http\Resources\Api\V1\CourseResource;
use App\Models\Course;
use App\Models\RepresentingInstitution;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use ApiResponse;
    public function index(RepresentingInstitution $representing_institution)
    {
        $data = $representing_institution->courses()->with(['currency'])->get();
        return CourseResource::collection($data);
    }
    public function store(StoreCourseRequest $request)
    {
        $course = Course::query()->create($request->getData());
        return CourseResource::make($course);
    }

    public function show(Course $course)
    {
        $course->load('currency');
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
            'is_active' => $request->is_active
        ]);
        return CourseResource::make($course);
    }
}
