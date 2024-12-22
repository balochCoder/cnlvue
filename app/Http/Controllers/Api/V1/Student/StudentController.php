<?php

namespace App\Http\Controllers\Api\V1\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Student\StoreStudentRequest;
use App\Http\Requests\Api\V1\Student\UpdateStudentRequest;
use App\Http\Resources\Api\V1\StudentResource;
use App\Jobs\Students\CreateStudent;
use App\Jobs\Students\UpdateStudent;
use App\Models\Student;
use App\Traits\ApiResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Bus\Dispatcher;
use Spatie\QueryBuilder\QueryBuilder;

class StudentController extends Controller
{
    public function __construct(
        private readonly Dispatcher $bus
    )
    {
    }

    public function index()
    {
        $students = QueryBuilder::for(Student::class)
            ->with(['lead'])
            ->getEloquentBuilder()
            ->get();
        return StudentResource::collection($students);
    }

    use ApiResponse;

    public function store(StoreStudentRequest $request)
    {
        $attributes = [
            'storeData' => $request->getData(),
            'choices' => $request->choices,
        ];

        $this->bus->dispatch(
            command: new CreateStudent($attributes)
        );

        return $this->ok('Student generated successfully.');
    }

    public function show(Student $student)
    {
        $student = QueryBuilder::for(Student::class)
            ->where('id', $student->id)
            ->with(['lead'])
            ->firstOrFail();
        return StudentResource::make($student);
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $attributes = [
            'storeData' => $request->getData(),
            'choices' => $request->choices,
        ];
        $this->bus->dispatch(
            command: new UpdateStudent($attributes, $student)
        );
        return $this->ok('Student updated successfully.');
    }
    public function pdf(Student $student)
    {
        $pdf = Pdf::loadView('student.pdf', compact('student'));
        return $pdf->download('student.pdf');
    }
}
