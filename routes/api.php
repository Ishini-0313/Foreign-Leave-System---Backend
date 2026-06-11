<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MinistryController;
use App\Http\Controllers\Api\DeptController;
use App\Http\Controllers\Api\DistrictOfficeController;

Route::get('/ministries', [MinistryController::class, 'index']);
Route::post('/ministries', [MinistryController::class, 'store']);

Route::get('/{id}/departments', [DeptController::class, 'getByMinistry']);
Route::post('/departments', [DeptController::class, 'store']);

Route::get('/{id}/districtOffices', [DistrictOfficeController::class, 'getByDept']);
Route::post('/districtOffices', [DistrictOfficeController::class, 'store']);