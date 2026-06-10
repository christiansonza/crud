<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AuthController;


/* AUTH ROUTES */
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout']);

/* PAGE ROUTES */

Route::middleware('auth.manual')->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [EmployeeController::class, 'index']);

    // EMPLOYEES
    Route::post('/employee/store', [EmployeeController::class, 'store']);
    Route::put('/employee/update/{id}', [EmployeeController::class, 'update']);
    Route::delete('/employee/delete/{id}', [EmployeeController::class, 'destroy']);

    // DEPARTMENTS
    Route::post('/department/store', [DepartmentController::class, 'store']);
    Route::put('/department/update/{id}', [DepartmentController::class, 'update']);
    Route::delete('/department/delete/{id}', [DepartmentController::class, 'destroy']);

});