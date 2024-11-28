<?php

use App\Models\Course;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/courses/{course}/pdf', function (\App\Models\Course $course) {
//    return view('course.pdf')->with('course', $course);
//});


//Route::get('/leads/{lead}/pdf', function (\App\Models\Lead $lead) {
//    $followupsCountByMode = $lead->followups()
//        ->selectRaw('follow_up_mode, COUNT(*) as count')
//        ->groupBy('follow_up_mode')
//        ->pluck('count', 'follow_up_mode')
//        ->toArray();
//
//    $lead->setRelation('followupsCountByMode', $followupsCountByMode);
//    return view('lead.report')->with('lead', $lead);
//});
