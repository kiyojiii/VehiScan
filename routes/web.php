<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ApplicantPartnerController;
use App\Http\Controllers\TimeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing/landing');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    #APPOINTMENTS
    Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::post('appointments/store', [AppointmentController::class, 'store']);
    Route::post('appointments/edit', [AppointmentController::class, 'edit']);
    Route::post('appointments/delete', [AppointmentController::class, 'destroy']);

    #ROLE STATUS
    Route::get('status', [StatusController::class, 'index'])->name('status.index');
    Route::post('status/store', [StatusController::class, 'store']);
    Route::post('status/edit', [StatusController::class, 'edit']);
    Route::post('status/delete', [StatusController::class, 'destroy']);

    #VIOLATION
    Route::get('violations', [ViolationController::class, 'index'])->name('violations.index');
    Route::post('violations/store', [ViolationController::class, 'store']);
    Route::post('violations/edit', [ViolationController::class, 'edit']);
    Route::post('violations/delete', [ViolationController::class, 'destroy']);

    #OWNER 
    Route::get('owners', [OwnerController::class, 'index'])->name('owners.index');
    Route::get('/fetchAllOwner', [OwnerController::class, 'fetchAllOwner'])->name('fetchAllOwner');
    Route::post('owners/store', [OwnerController::class, 'store'])->name('owners.store');
    Route::get('owners/edit', [OwnerController::class, 'edit'])->name('owners.edit');
    Route::post('owners/update', [OwnerController::class, 'update'])->name('owners.update');
    Route::delete('owners/delete', [OwnerController::class, 'delete'])->name('owners.delete');
    Route::get('owners/show/{id}', [OwnerController::class, 'show'])->name('owners.show');

    #VEHICLE
    Route::get('vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/fetchAllVehicle', [VehicleController::class, 'fetchAllVehicle'])->name('fetchAllVehicle');
    Route::post('vehicles/store', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::get('vehicles/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
    Route::post('vehicles/update', [VehicleController::class, 'update'])->name('vehicles.update');
    Route::delete('vehicles/delete', [VehicleController::class, 'delete'])->name('vehicles.delete');
    Route::get('vehicles/show/{id}', [VehicleController::class, 'show'])->name('vehicles.show');

    #DRIVER
    Route::get('drivers', [DriverController::class, 'index'])->name('drivers.index');
    Route::get('/fetchAllDriver', [DriverController::class, 'fetchAllDriver'])->name('fetchAllDriver');
    Route::post('drivers/store', [DriverController::class, 'store'])->name('drivers.store');
    Route::get('drivers/edit', [DriverController::class, 'edit'])->name('drivers.edit');
    Route::post('drivers/update', [DriverController::class, 'update'])->name('drivers.update');
    Route::delete('drivers/delete', [DriverController::class, 'delete'])->name('drivers.delete');
    Route::get('drivers/show/{id}', [DriverController::class, 'show'])->name('drivers.show');

    #APPLICANT
    Route::get('applicants', [ApplicantController::class, 'index'])->name('applicants.index');
    Route::get('applicants-manage', [ApplicantController::class, 'manage'])->name('applicants.manage');
    Route::post('applicants/store', [ApplicantController::class, 'store'])->name('applicants.store');
    #OWNER UPDATE
    Route::get('applicants/edit', [ApplicantController::class, 'edit'])->name('applicants.edit');
    Route::post('applicants/update', [ApplicantController::class, 'update'])->name('applicants.update');
    #VEHICLE UPDATE
    Route::get('applicants/edit_vehicle', [ApplicantController::class, 'edit_vehicle'])->name('applicants.edit_vehicle');
    Route::post('applicants/update_vehicle', [ApplicantController::class, 'update_vehicle'])->name('applicants.update_vehicle');
    #DRIVER UPDATE
    Route::get('applicants/edit_driver', [ApplicantController::class, 'edit_driver'])->name('applicants.edit_driver');
    Route::post('applicants/update_driver', [ApplicantController::class, 'update_driver'])->name('applicants.update_driver');

    Route::get('applicants/show/{id}', [ApplicantController::class, 'show'])->name('applicants.show');

    #TEST ROUTE
    Route::get('test', [TimeController::class, 'test'])->name('time.test');
    Route::get('/fetchVehicleRecord', [TimeController::class, 'fetchVehicleRecord'])->name('fetchVehicleRecord');

    #TIME
    Route::post('/record-time-in', [TimeController::class, 'recordTimeIn'])->name('record.time.in');
    Route::post('/check-time-in', [TimeController::class, 'checkTimeIn'])->name('check.time.in');
    Route::post('/record-time-out', [TimeController::class, 'recordTimeOut'])->name('record.time.out');

    // search route
    Route::get("search",[TimeController::class,'search']);

    // Route::get('applicants/edit/{id}', [ApplicantController::class, 'edit'])->name('applicants.edit');
    // Route::post('applicants/update/{id}', [ApplicantController::class, 'update'])->name('applicants.update');
    // Route::get('applicants/show/{id}', [ApplicantController::class, 'show'])->name('applicants.show');

    Route::get('/fetchPendingApplicant', [ApplicantController::class, 'fetchPendingApplicant'])->name('fetchPendingApplicant');
    Route::get('/ManageApplicant', [ApplicantController::class, 'ManageApplicant'])->name('ManageApplicant');

    #APPLICANT PARTNER/SUPPLIER
    Route::get('applicants-partner', [ApplicantPartnerController::class, 'index'])->name('applicants.index-partner');
    Route::get('applicants-partner-rejected', [ApplicantPartnerController::class, 'rejected'])->name('applicants.rejected-partner');
    Route::get('/fetchAllPartnerApplicant', [ApplicantPartnerController::class, 'fetchAllPartnerApplicant'])->name('fetchAllPartnerApplicant');
    Route::get('/fetchAllRejectedPartnerApplicant', [ApplicantPartnerController::class, 'fetchAllRejectedPartnerApplicant'])->name('fetchAllRejectedPartnerApplicant');

    #FORMS
    Route::get('applicants-form', [ApplicantController::class, 'form'])->name('forms.applicant');
});


Route::resources([
    'roles' => RoleController::class,
    'users' => UserController::class,
    'products' => ProductController::class,
]);


Route::view('/example-page', 'example-page');
Route::view('/example-auth', 'example-auth');
