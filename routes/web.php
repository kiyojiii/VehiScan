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
use App\Http\Controllers\TestController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Auth\RegisterController;


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
Route::get('/fetchHomeVehicleRecord', [HomeController::class, 'fetchHomeVehicleRecord'])->name('fetchHomeVehicleRecord');

#APPLICANT PROFILE
Route::get('/user-profile', [HomeController::class, 'user_profile'])->name('applicant_users.user_profile');

#APPLICANT HOME DASHBOARD
Route::get('/applicant-dashboard', [HomeController::class, 'user_index'])->name('applicant_users.applicant_home');
Route::post('applicant/vehicles/store', [HomeController::class, 'applicant_add_vehicle'])->name('applicant_users.store');
Route::get('applicant/edit', [HomeController::class, 'applicant_edit_owner'])->name('applicant_users.edit_owner');
Route::post('applicant/update', [HomeController::class, 'applicant_update_owner'])->name('applicant_users.update_owner');
Route::get('applicant/edit/driver', [HomeController::class, 'applicant_edit_driver'])->name('applicant_users.edit_driver');
Route::post('applicant/update/driver', [HomeController::class, 'applicant_update_driver'])->name('applicant_users.update_driver');
Route::get('applicant/vehicles/activate', [HomeController::class, 'applicant_vehicle_activate'])->name('applicant_vehicle.activate_vehicle');
Route::post('applicant/vehicles/submit-activation', [HomeController::class, 'applicant_vehicle_activate_update'])->name('applicant_vehicle.activate_vehicle_submit');

#APPLICANT VIOLATION
Route::get('/applicant-violation', [HomeController::class, 'user_violation'])->name('applicant_users.applicant_violation');
Route::get('/fetchAllApplicantViolation', [HomeController::class, 'fetchAllApplicantViolation'])->name('fetchAllApplicantViolation');

#APPLICANT VEHICLES
Route::get('/applicant-vehicles', [HomeController::class, 'user_vehicles'])->name('applicant_users.applicant_vehicle');
Route::get('/fetchAllApplicantVehicle', [HomeController::class, 'fetchAllApplicantVehicle'])->name('fetchAllApplicantVehicle');
Route::get('applicant/vehicles/edit', [HomeController::class, 'applicant_vehicle_edit'])->name('applicant_vehicle.edit');
Route::post('applicant/vehicles/update', [HomeController::class, 'applicant_vehicle_update'])->name('applicant_vehicle.update');
Route::delete('applicant/vehicles/delete', [HomeController::class, 'applicant_vehicle_delete'])->name('applicant_vehicle.delete');
Route::get('applicant/vehicles/view', [HomeController::class, 'applicant_vehicle_view'])->name('applicant_vehicle.view');

#APPLICANT GRAPH
Route::get('/applicant-analytics', [HomeController::class, 'applicant_analytics'])->name('applicant_users.applicant_analytics');
Route::get('/fetchAllApplicantTime', [HomeController::class, 'fetchAllApplicantTime'])->name('fetchAllApplicantTime');

#APPLICANT APPLY APPLICATION
Route::get('/applicant-apply', [HomeController::class, 'user_apply'])->name('applicant_users.applicant_apply');
Route::get('/fetchAllApplicantDetails', [HomeController::class, 'fetchAllApplicantDetails'])->name('fetchAllApplicantDetails');

#APPLICANT HISTORY
Route::get('/applicant-history', [HomeController::class, 'user_history'])->name('applicant_users.applicant_history');
Route::get('/fetchApplicantAudit', [HomeController::class, 'fetchApplicantAudit'])->name('fetchApplicantAudit');
Route::get('/fetchApplicantVehicleAudit', [HomeController::class, 'fetchApplicantVehicleAudit'])->name('fetchApplicantVehicleAudit');
Route::get('/fetchApplicantDriverAudit', [HomeController::class, 'fetchApplicantDriverAudit'])->name('fetchApplicantDriverAudit');

#APPLICANT VEHICLE INFORMATION
Route::get('applicant/vehicle_information/{id}', [HomeController::class, 'vehicle_information'])->name('applicant_users.vehicle_information');

#APPLICANT APPLICATION
Route::post('applicant-apply/store', [HomeController::class, 'store'])->name('applicant.store');
Route::delete('applicant-apply/delete', [HomeController::class, 'delete'])->name('applicant.delete');
#OWNER UPDATE
Route::get('applicant-apply/edit', [HomeController::class, 'edit'])->name('applicant.edit');
Route::post('applicant-apply/update', [HomeController::class, 'update'])->name('applicant.update');
#VEHICLE UPDATE
Route::get('applicant-apply/edit_vehicle', [HomeController::class, 'edit_vehicle'])->name('applicant.edit_vehicle');
Route::post('applicant-apply/update_vehicle', [HomeController::class, 'update_vehicle'])->name('applicant.update_vehicle');
#DRIVER UPDATE
Route::get('applicant-apply/edit_driver', [HomeController::class, 'edit_driver'])->name('applicant.edit_driver');
Route::post('applicant-apply/update_driver', [HomeController::class, 'update_driver'])->name('applicant.update_driver');


Route::middleware(['auth'])->group(function () {
    #APPOINTMENTS
    Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/fetchAllAppointment', [AppointmentController::class, 'fetchAllAppointment'])->name('fetchAllAppointment');
    Route::post('appointments/store', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('appointments/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::post('appointments/update', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('appointments/delete', [AppointmentController::class, 'delete'])->name('appointments.delete');

    #ROLE STATUS
    Route::get('status', [StatusController::class, 'index'])->name('status.index');
    Route::get('/fetchAllRoleStatus', [StatusController::class, 'fetchAllRoleStatus'])->name('fetchAllRoleStatus');
    Route::post('status/store', [StatusController::class, 'store'])->name('status.store');
    Route::get('status/edit', [StatusController::class, 'edit'])->name('status.edit');
    Route::post('status/update', [StatusController::class, 'update'])->name('status.update');
    Route::delete('status/delete', [StatusController::class, 'delete'])->name('status.delete');

    #VIOLATION
    Route::get('violations', [ViolationController::class, 'index'])->name('violations.index');
    Route::get('/fetchAllViolation', [ViolationController::class, 'fetchAllViolation'])->name('fetchAllViolation');
    Route::post('violations/store', [ViolationController::class, 'store'])->name('violations.store');
    Route::get('violations/edit', [ViolationController::class, 'edit'])->name('violations.edit');
    Route::post('violations/update', [ViolationController::class, 'update'])->name('violations.update');
    Route::delete('violations/delete', [ViolationController::class, 'delete'])->name('violations.delete');

    #OWNER 
    Route::get('owners', [OwnerController::class, 'index'])->name('owners.index');
    Route::get('/fetchAllOwner', [OwnerController::class, 'fetchAllOwner'])->name('fetchAllOwner');
    Route::post('owners/store', [OwnerController::class, 'store'])->name('owners.store');
    Route::get('owners/edit', [OwnerController::class, 'edit'])->name('owners.edit');
    Route::post('owners/update', [OwnerController::class, 'update'])->name('owners.update');
    Route::delete('owners/delete', [OwnerController::class, 'delete'])->name('owners.delete');
    Route::get('owners/show/{id}', [OwnerController::class, 'show'])->name('owners.show');
    Route::get('/fetchAllOwnerVehicle', [OwnerController::class, 'fetchAllOwnerVehicle'])->name('fetchAllOwnerVehicle');
    Route::get('owners/vehicle_information/{id}', [OwnerController::class, 'vehicle_information'])->name('owners.vehicle_information');

    #VEHICLE
    Route::get('vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/fetchAllVehicle', [VehicleController::class, 'fetchAllVehicle'])->name('fetchAllVehicle');
    Route::post('vehicles/store', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::get('vehicles/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
    Route::post('vehicles/update', [VehicleController::class, 'update'])->name('vehicles.update');
    Route::delete('vehicles/deactivate', [VehicleController::class, 'deactivate_vehicle'])->name('vehicles.deactivate');
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
    Route::delete('applicants/delete', [ApplicantController::class, 'delete'])->name('applicants.delete');
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

    #VEHICLE INFORMATION UPDATE
    Route::get('vehicle_information/edit_vehicle', [OwnerController::class, 'edit_vehicle'])->name('owners.edit_vehicle');
    Route::post('vehicle_information/update_vehicle', [OwnerController::class, 'update_vehicle'])->name('owners.update_vehicle');
    Route::delete('vehicle_information/delete', [OwnerController::class, 'delete_vehicle'])->name('owners.delete_vehicle');

    #DRIVER INFORMATION UPDATE
    Route::get('vehicle_information/edit_driver', [OwnerController::class, 'edit_driver'])->name('owners.edit_driver');
    Route::post('vehicle_information/update_driver', [OwnerController::class, 'update_driver'])->name('owners.update_driver');

    #VEHICLE RECORD ROUTE
    Route::controller(TimeController::class)->group(function () {
        Route::get('record-vehicles', 'record_vehicle')->name('time.record_vehicles');
        Route::get('/fetchVehicleRecord', 'fetchVehicleRecord')->name('fetchVehicleRecord');
        Route::get("record", 'record');
    });

    #TIME
    Route::get('time', [TimeController::class, 'index'])->name('time.index');
    Route::get('/fetchAllTime', [TimeController::class, 'fetchAllTime'])->name('fetchAllTime');
    Route::post('/record-time-in', [TimeController::class, 'recordTimeIn'])->name('record.time.in');
    Route::post('create-vehicle-record', [TimeController::class, 'createVehicleRecord'])->name('create.vehicle.record');
    Route::post('/check-time-in', [TimeController::class, 'checkTimeIn'])->name('check.time.in');
    Route::post('/record-time-out', [TimeController::class, 'recordTimeOut'])->name('record.time.out');

    #DOWNLOAD QR ROUTE
    Route::get('/downloadQRCode/{qrData}', [VehicleController::class, 'downloadQRCode'])->name('downloadQRCode');
    Route::get('/download-qr-code', [VehicleController::class, 'downloadQRCode'])->name('download.qr.code');
    Route::post('/save-qr-code', [VehicleController::class, 'saveQRCode'])->name('save.qr.code');
    Route::get('qrcode/download', [QRCodeController::class, 'download'])->name('qrcode.download');
    Route::get('/getPlateNumber', [QRCodeController::class, 'getPlateNumber'])->name('getPlateNumber');

    #PERMISSIONS
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/fetchAllPermission', [PermissionController::class, 'fetchAllPermission'])->name('fetchAllPermission');
    Route::post('permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('permissions/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('permissions/update', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('permissions/delete', [PermissionController::class, 'delete'])->name('permissions.delete');

    #TEST
    Route::get('scratch', [TestController::class, 'index'])->name('test');
    Route::get('/fetchTest', [TestController::class, 'fetchTest'])->name('fetchTest');
    Route::get('/fetchRecordDetails', [TestController::class, 'fetchRecordDetails'])->name('fetchRecordDetails');


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
