<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OfficeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TrackingController;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// get all institutes
Route::get('/office', [OfficeController::class, 'index']);

// get all services
Route::get('/services', [ServiceController::class, 'index']);

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

Route::get('/sub-offices', [OfficeController::class, 'get_sub_office_by_ministry']);

Route::get(
    '/applications/{id}/general126',
    [ApplicationController::class, 'generateGeneral126']
);

Route::get(
    '/applications/{id}',
    [ApplicationController::class, 'show']
);

Route::middleware('auth:sanctum')->get(
    '/my-application',
    [ApplicationController::class, 'myApplication']
);

Route::get('/office-by-id', [OfficeController::class, 'getOfficeById']);

Route::get('/grade-by-id', [GradeController::class, 'getClassById']);

Route::get('/role-by-id', [RoleController::class, 'getRoleById']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/officer/pending-applications', [OfficerController::class, 'pending']);
});

Route::get('/applications/{id}/tracking', [TrackingController::class, 'index']);

Route::get('/applications/{id}/documents', [ApplicationController::class, 'documents']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post(
        '/applications/{application}/forward',
        [OfficerController::class, 'forward']
    );
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post(
        '/applications/{application}/return',
        [OfficerController::class, 'return']
    );
});