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
    Route::get('appointments', [App\Http\Controllers\AppointmentController::class, 'index'])->name('appointments.index');
    Route::post('appointments/store', [App\Http\Controllers\AppointmentController::class, 'store']);
    Route::post('appointments/edit', [App\Http\Controllers\AppointmentController::class, 'edit']);
    Route::post('appointments/delete', [App\Http\Controllers\AppointmentController::class, 'destroy']);

    #ROLE STATUS
    Route::get('status', [App\Http\Controllers\StatusController::class, 'index'])->name('status.index');
    Route::post('status/store', [App\Http\Controllers\StatusController::class, 'store']);
    Route::post('status/edit', [App\Http\Controllers\StatusController::class, 'edit']);
    Route::post('status/delete', [App\Http\Controllers\StatusController::class, 'destroy']);

    #VIOLATION
    Route::get('violations', [App\Http\Controllers\ViolationController::class, 'index'])->name('violations.index');
    Route::post('violations/store', [App\Http\Controllers\ViolationController::class, 'store']);
    Route::post('violations/edit', [App\Http\Controllers\ViolationController::class, 'edit']);
    Route::post('violations/delete', [App\Http\Controllers\ViolationController::class, 'destroy']);
});


Route::resources([
    'roles' => RoleController::class,
    'users' => UserController::class,
    'products' => ProductController::class,
]);


Route::view('/example-page', 'example-page');
Route::view('/example-auth', 'example-auth');
