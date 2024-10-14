<?php


use App\Http\Controllers\Api\V1\ApplicationProcess\ApplicationProcessController;
use App\Http\Controllers\Api\V1\Branch\BranchController;
use App\Http\Controllers\Api\V1\ProcessingOffice\ProcessingOfficeController;
use App\Http\Controllers\Api\V1\Counsellor\CounsellorController;
use App\Http\Controllers\Api\V1\Country\CountryController;
use App\Http\Controllers\Api\V1\Course\CourseController;
use App\Http\Controllers\Api\V1\Currency\CurrencyController;
use App\Http\Controllers\Api\V1\Enum\EnumController;
use App\Http\Controllers\Api\V1\FrontOffice\FrontOfficeController;
use App\Http\Controllers\Api\V1\RepresentingCountry\RepresentingCountryController;
use App\Http\Controllers\Api\V1\RepresentingInstitution\RepresentingInstitutionController;
use App\Http\Controllers\Api\V1\SubStatus\SubStatusController;
use App\Http\Controllers\Api\V1\TimeZone\TimeZoneController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::get('users', function () {
        return \App\Http\Resources\Api\V1\UserResource::collection(\App\Models\User::all());
    });
    //Representing Countries Routes
    Route::get('countries', CountryController::class)->name('countries.index');
    Route::apiResource('representing-countries', RepresentingCountryController::class)
        ->only(['index', 'store', 'show']);
    Route::patch('representing-countries/{representing_country}/status', [RepresentingCountryController::class, 'status'])->name('representing-countries.status');

    //Application Process Routes
    Route::apiResource('representing-countries.application-processes', ApplicationProcessController::class)
        ->shallow()
        ->only(['show', 'update', 'store']);
    Route::patch('representing-countries/{representing_country}/application-processes/notes', [ApplicationProcessController::class, 'updateNotes'])
        ->name('representing-countries.notes.update');
    Route::patch('application-processes/{application_process}/status', [ApplicationProcessController::class, 'status'])
        ->name('application-processes.status');
    Route::patch('application-processes/reorder/update', [ApplicationProcessController::class, 'updateOrder'])
        ->name('application-processes.reorder.update');

    //Sub Statuses
    Route::apiResource('application-processes.sub-statuses', SubStatusController::class)
        ->shallow()
        ->only(['store', 'update']);
    Route::patch('sub-statuses/{sub_status}/status', [SubStatusController::class, 'status'])
        ->name('sub-statuses.status');

    //Enums
    Route::get('enums/institute-types', [EnumController::class, 'instituteTypes']);
    Route::get('enums/applicant-desired', [EnumController::class, 'applicantDesired']);
    Route::get('enums/course-levels', [EnumController::class, 'courseLevels']);
    Route::get('enums/course-categories', [EnumController::class, 'courseCategories']);
    Route::get('enums/download-csv', [EnumController::class, 'downloadCSV']);

    //Currency
    Route::get('currencies', CurrencyController::class);
    //Time Zone
    Route::get('time-zones', TimeZoneController::class);

    //Representing Institution
    Route::apiResource('representing-institutions', RepresentingInstitutionController::class)
        ->only(['index', 'store', 'show', 'update']);
    Route::patch('representing-institutions/{representing_institution}/status', [RepresentingInstitutionController::class, 'status'])
        ->name('representing-institutions.status');

    //Courses
    Route::apiResource('courses', CourseController::class)
        ->except(['index', 'destroy']);
    Route::patch('courses/{course}/status', [CourseController::class, 'status']);

    //Branch
    Route::apiResource('branches', BranchController::class)
        ->except(['destroy']);
    Route::patch('branches/{branch}/status', [BranchController::class, 'status']);

    //Counsellor
    Route::apiResource('counsellors', CounsellorController::class)
        ->except(['destroy']);
    Route::patch('counsellors/{counsellor}/status', [CounsellorController::class, 'status']);

    Route::post('counsellors/{counsellor}/assigned-institutions', [CounsellorController::class, 'assign']);

    Route::get('counsellors/{counsellor}/assigned-institutions', [CounsellorController::class, 'getAssignedInstitutions']);

    //Front Office
    Route::apiResource('front-offices', FrontOfficeController::class)
        ->except(['destroy']);
    Route::patch('front-offices/{front_office}/status', [FrontOfficeController::class, 'status']);

    //Processing Office
    Route::apiResource('processing-offices', ProcessingOfficeController::class)
        ->except(['destroy']);
    Route::patch('processing-offices/{processing_office}/status', [ProcessingOfficeController::class, 'status']);
});

