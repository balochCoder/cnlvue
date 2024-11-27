<?php

use App\Models\Course;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/courses/{course}/pdf', function (\App\Models\Quotation $course) {
//    return view('course.pdf')->with('course', $course);
//});
