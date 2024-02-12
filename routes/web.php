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

    #OWNER / APPLICANTS
    Route::get('owners', [OwnerController::class, 'index'])->name('owners.index');
    Route::get('/fetchAllOwner', [OwnerController::class, 'fetchAllOwner'])->name('fetchAllOwner');
    Route::post('owners/store', [OwnerController::class, 'store'])->name('owners.store');
    Route::get('owners/edit', [OwnerController::class, 'edit'])->name('owners.edit');
    Route::post('owners/update', [OwnerController::class, 'update'])->name('owners.update');
    Route::delete('owners/delete', [OwnerController::class, 'delete'])->name('owners.delete');
    Route::get('owners/show/{id}', [OwnerController::class, 'show'])->name('owners.show');

    #VEHICLE
    Route::get('vehicles', [VehicleController::class, 'index'])->name('vehicles.index');

    #DRIVER
    Route::get('drivers', [DriverController::class, 'index'])->name('drivers.index');
    Route::get('/fetchAllDriver', [DriverController::class, 'fetchAllDriver'])->name('fetchAllDriver');
    Route::post('drivers/store', [DriverController::class, 'store'])->name('drivers.store');
    Route::get('drivers/edit', [DriverController::class, 'edit'])->name('drivers.edit');
    Route::post('drivers/update', [DriverController::class, 'update'])->name('drivers.update');
    Route::delete('drivers/delete', [DriverController::class, 'delete'])->name('drivers.delete');
    Route::get('drivers/show/{id}', [DriverController::class, 'show'])->name('drivers.show');

});


Route::resources([
    'roles' => RoleController::class,
    'users' => UserController::class,
    'products' => ProductController::class,
]);


Route::view('/example-page', 'example-page');
Route::view('/example-auth', 'example-auth');
