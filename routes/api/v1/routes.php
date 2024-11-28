<?php

use App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::get('users', function () {
        return UserResource::collection(User::all());
    })->name('users');

    //Representing Countries Routes
    Route::get('countries', V1\Country\CountryController::class)->name('countries.index');
    Route::apiResource('representing-countries', V1\RepresentingCountry\RepresentingCountryController::class)
        ->only(['index', 'store', 'show']);
    Route::patch('representing-countries/{representing_country}/status', [V1\RepresentingCountry\RepresentingCountryController::class, 'status'])->name('representing-countries.status');

    //Application Process Routes
    Route::apiResource('representing-countries.application-processes', V1\ApplicationProcess\ApplicationProcessController::class)
        ->shallow()
        ->only(['show', 'update', 'store']);
    Route::patch('representing-countries/{representing_country}/application-processes/notes', [V1\ApplicationProcess\ApplicationProcessController::class, 'updateNotes'])
        ->name('representing-countries.notes.update');
    Route::patch('application-processes/{application_process}/status', [V1\ApplicationProcess\ApplicationProcessController::class, 'status'])
        ->name('application-processes.status');
    Route::patch('application-processes/reorder/update', [V1\ApplicationProcess\ApplicationProcessController::class, 'updateOrder'])
        ->name('application-processes.reorder.update');

    //Sub Statuses
    Route::apiResource('application-processes.sub-statuses', V1\SubStatus\SubStatusController::class)
        ->shallow()
        ->only(['store', 'update']);
    Route::patch('sub-statuses/{sub_status}/status', [V1\SubStatus\SubStatusController::class, 'status'])
        ->name('sub-statuses.status');

    //Enums
    Route::get('enums/institute-types', [V1\Enum\EnumController::class, 'instituteTypes']);
    Route::get('enums/applicant-desired', [V1\Enum\EnumController::class, 'applicantDesired']);
    Route::get('enums/course-levels', [V1\Enum\EnumController::class, 'courseLevels']);
    Route::get('enums/course-categories', [V1\Enum\EnumController::class, 'courseCategories']);
    Route::get('enums/download-csv', [V1\Enum\EnumController::class, 'downloadCSV']);
    Route::get('enums/associate-categories', [V1\Enum\EnumController::class, 'associateCategories']);
    Route::get('enums/lead-statuses', [V1\Enum\EnumController::class, 'leadStatuses']);
    Route::get('enums/followup-modes', [V1\Enum\EnumController::class, 'followupModes']);
    Route::get('enums/task-statuses', [V1\Enum\EnumController::class, 'taskStatuses']);

    //Currency
    Route::get('currencies', V1\Currency\CurrencyController::class);

    //Time Zone
    Route::get('time-zones', V1\TimeZone\TimeZoneController::class);

    //Representing Institution
    Route::apiResource('representing-institutions', V1\RepresentingInstitution\RepresentingInstitutionController::class)
        ->only(['index', 'store', 'show', 'update']);
    Route::patch('representing-institutions/{representing_institution}/status', [V1\RepresentingInstitution\RepresentingInstitutionController::class, 'status'])
        ->name('representing-institutions.status');

    Route::get('representing-institutions/{representing_institution}/courses', [V1\RepresentingInstitution\RepresentingInstitutionController::class, 'courses'])->name('representingInstitutions.courses');

    //Courses
    Route::apiResource('courses', V1\Course\CourseController::class)
        ->except(['destroy']);
    Route::patch('courses/{course}/status', [V1\Course\CourseController::class, 'status']);

    Route::get('courses/{course}/pdf',[V1\Course\CourseController::class, 'pdf']);
    //Branch
    Route::apiResource('branches', V1\Branch\BranchController::class)
        ->except(['destroy']);
    Route::patch('branches/{branch}/status', [V1\Branch\BranchController::class, 'status']);

    //Counsellor
    Route::apiResource('counsellors', V1\Counsellor\CounsellorController::class)
        ->except(['destroy']);
    Route::patch('counsellors/{counsellor}/status', [V1\Counsellor\CounsellorController::class, 'status']);
    Route::post('counsellors/{counsellor}/assigned-institutions', [V1\Counsellor\CounsellorController::class, 'assign']);
    Route::get('counsellors/{counsellor}/assigned-institutions', [V1\Counsellor\CounsellorController::class, 'getAssignedInstitutions']);

    // Remarks
    Route::apiResource('remarks', V1\Remark\RemarkController::class)
        ->except(['index', 'destroy']);

    // Targets
    Route::apiResource('targets', V1\Target\TargetController::class)
        ->except(['index', 'destroy']);

    //Front Office
    Route::apiResource('front-offices', V1\FrontOffice\FrontOfficeController::class)
        ->except(['destroy']);
    Route::patch('front-offices/{front_office}/status', [V1\FrontOffice\FrontOfficeController::class, 'status']);

    //Processing Office
    Route::apiResource('processing-offices', V1\ProcessingOffice\ProcessingOfficeController::class)
        ->except(['destroy']);
    Route::patch('processing-offices/{processing_office}/status', [V1\ProcessingOffice\ProcessingOfficeController::class, 'status']);

    Route::post('processing-offices/{processing_office}/assigned-institutions', [V1\ProcessingOffice\ProcessingOfficeController::class, 'assign']);
    Route::get('processing-offices/{processing_office}/assigned-institutions', [V1\ProcessingOffice\ProcessingOfficeController::class, 'getAssignedInstitutions']);

    // Associate
    Route::apiResource('associates', V1\Associate\AssociateController::class)
        ->except(['destroy']);
    Route::patch('associates/{associate}/status', [V1\Associate\AssociateController::class, 'status']);

    //Lead Sources
    Route::apiResource('lead-sources', V1\LeadSource\LeadSourceController::class)
        ->except(['destroy']);
    Route::patch('lead-sources/{lead_source}/status', [V1\LeadSource\LeadSourceController::class, 'status']);

    //Leads
    Route::apiResource('leads', V1\Lead\LeadController::class)
        ->except(['destroy']);
    Route::apiResource('followups', V1\Followup\FollowupController::class)
        ->only(['store', 'index']);
    Route::get('leads/{lead}/pdf',[V1\Lead\LeadController::class, 'pdf']);


    //Tasks
    Route::get('tasks',[V1\Task\TaskController::class, 'index'])
    ->name('tasks.index');
    Route::get('tasks/assigned-by-me', [V1\Task\TaskController::class, 'assignedByMe'])->name('tasks.assignedByMe');
    Route::get('/tasks/assigned-to-me', [V1\Task\TaskController::class, 'assignedToMe'])->name('tasks.assignedToMe');

    Route::post('/tasks', [V1\Task\TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [V1\Task\TaskController::class, 'show'])->name('tasks.show');

    Route::patch('/tasks/{task}', [V1\Task\TaskController::class, 'update'])->name('/tasks.update');

//    Quotations
    Route::get('quotations', [ V1\Quotation\QuotationController::class, 'index'])->name('quotations.index');
    Route::get('quotations/{quotation}', [V1\Quotation\QuotationController::class, 'show'])->name('quotations.show');
    Route::post('quotations', [V1\Quotation\QuotationController::class, 'store'])->name('quotations.store');
    Route::put('quotations/{quotation}',[V1\Quotation\QuotationController::class,'update'])->name('quotations.update');
    Route::get('quotations/{quotation}/pdf',[V1\Quotation\QuotationController::class, 'pdf']);


//    Roles
    Route::get('roles',[V1\Role\RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/{role}/users',[V1\Role\RoleController::class, 'getUsers'])->name('roles.users');
});

