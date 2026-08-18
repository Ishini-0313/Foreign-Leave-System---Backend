<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OfficeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AmendmentsController;
use App\Http\Controllers\AmendmentTrackingController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\OfficerAssignmentController;
use App\Http\Controllers\ApprovalLetterController;
use App\Http\Controllers\CompletedApplicationController;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// get all institutes
Route::get('/office', [OfficeController::class, 'index']);

// get all services
Route::get('/services', [ServiceController::class, 'index']);

// get all designations
Route::get('/designations', [DesignationController::class, 'index']);

// get all ministries
Route::get('/ministries', [OfficeController::class, 'getMinistries']);

// get departments,district offices and offices
Route::get('/institutes', [OfficeController::class, 'getDept_distOffices_offices']);

// get all grades
Route::get('/grades', [GradeController::class, 'index']);

// sumbit application
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/application', [ApplicationController::class, 'store']);
});

// re-sumbit application
Route::middleware('auth:sanctum')->group(function () {
    Route::put('/application/{applicationId}/resubmit', [ApplicationController::class, 'restore']);
});

// sumbit amendment
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/amendment', [AmendmentsController::class, 'store']);
});

Route::get('/sub-offices', [OfficeController::class, 'get_sub_office_by_ministry']);

Route::get(
    '/applications/{id}/general126',
    [ApplicationController::class, 'generateGeneral126']
);

Route::get(
    '/applications/{id}',
    [ApplicationController::class, 'show']
);

Route::get(
    '/amendments/{id}',
    [AmendmentsController::class, 'show']
);

Route::middleware('auth:sanctum')->get(
    '/my-application',
    [ApplicationController::class, 'myApplication']
);

//get amendment related to application id
Route::middleware('auth:sanctum')->get(
    '/amendments/{application_id}',
    [AmendmentsController::class, 'getAmendments']
);

Route::get('/office-by-id', [OfficeController::class, 'getOfficeById']);

Route::get('/grade-by-id', [GradeController::class, 'getClassById']);

Route::get('/role-by-id', [RoleController::class, 'getRoleById']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/officer/pending-applications', [OfficerController::class, 'myQueue']);
    Route::get('/officer/all-applications', [OfficerController::class, 'allApplications']);
    Route::get('/officer/all-sub-applications', [OfficerController::class, 'allSubApplications']);
});

Route::get('/applications/{id}/tracking', [TrackingController::class, 'index']);
Route::get('/amendments/{id}/tracking', [AmendmentTrackingController::class, 'index']);

Route::get('/applications/{id}/documents', [ApplicationController::class, 'documents']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post(
        '/applications/{application}/forward',
        [OfficerController::class, 'forward']
    );

    Route::post(
        '/applications/{application}/return',
        [OfficerController::class, 'return']
    );

    Route::post(
        '/applications/{application}/approve',
        [OfficerController::class, 'approve']
    );
});

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::put('/password-change', [ProfileController::class, 'changePassword']);
});

Route::post(
    '/application/{id}/office-form',
    [LeaveController::class,'save']
)->middleware('auth:sanctum');

Route::post('/forgot-password', [PasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [PasswordController::class, 'resetPassword']);

// Route::middleware('auth:sanctum')->group(function () {

//     Route::get(
//         '/offices/assignable',
//         [OfficerAssignmentController::class, 'assignableOffices']
//     );

//     Route::get(
//         '/offices/{office}/assignment',
//         [OfficerAssignmentController::class, 'show']
//     );

//     Route::get(
//         '/offices/{office}/assignment/users',
//         [OfficerAssignmentController::class, 'users']
//     );

//     Route::post(
//         '/offices/{office}/assignment',
//         [OfficerAssignmentController::class, 'assign']
//     );

//     Route::post(
//         '/office-assignments/bootstrap-cs-admin',
//         [OfficerAssignmentController::class, 'assignCsPersonalTrainingAdmin']
//     );
// });

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/offices/assignable', [OfficerAssignmentController::class, 'assignableOffices']);

    Route::get('/offices/{office}/assignment', [OfficerAssignmentController::class, 'show']);

    Route::get('/offices/{office}/users', [OfficerAssignmentController::class, 'users']);

    Route::post('/offices/{office}/assignment', [OfficerAssignmentController::class, 'assign']);

    Route::get(
        '/my-admin-offices',
        [OfficerAssignmentController::class, 'myAdminOffices']
    );

});

Route::middleware('auth:sanctum')->group(function () {
    Route::get(
        '/applications/{application}/approval-letter',
        [ApprovalLetterController::class, 'viewApprovalLetter']
    );

    Route::get(
        '/applications/{application}/approval-letter/download',
        [ApprovalLetterController::class, 'downloadApprovalLetter']
    );
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get(
        '/applications/{application}/completed-form-16',
        [CompletedApplicationController::class, 'view16']
    );
    Route::get(
        '/applications/{application}/completed-form-16/download',
        [CompletedApplicationController::class, 'download16']
    );
    Route::get(
        '/applications/{application}/completed-form-126',
        [CompletedApplicationController::class, 'view126']
    );
    Route::get(
        '/applications/{application}/completed-form-126/download',
        [CompletedApplicationController::class, 'download126']
    );
});

